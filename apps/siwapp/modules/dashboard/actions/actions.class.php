<?php

/**
 * dashboard actions.
 *
 * @package    siwapp
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class dashboardActions extends sfActions
{
  public function preExecute()
  {
    $this->currency = $this->getUser()->getAttribute('currency');
    $this->namespace = 'invoices';
  }

 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $namespace = $request->getParameter('searchNamespace');
    $search = $this->getUser()->getAttribute('search', null, $namespace);
    $this->maxResults = sfConfig::get('app_dashboard_max_results');
    $company_id=sfContext::getInstance()->getUser()->getAttribute('company_id');
    $company = Doctrine::getTable('Company')->find($company_id);
    $this->fiscality=$company->fiscality;
    if($this->fiscality){
        //Incoming expenses grouped by Tax id.
        $q = InvoiceQuery::create()->innerJoin('i.Items it')->innerJoin('it.Taxes t')
            ->addSelect('t.name as name')->addSelect('t.value as value ')
            ->addSelect('i.id')->addSelect('it.id')->addSelect('t.id') //Necesary for doctrine
            ->addSelect('sum(
        CASE WHEN discount >0
        THEN ((100-it.discount) / 100) * (it.unitary_cost * it.quantity)
        ELSE it.unitary_cost * it.quantity
        END ) AS base')

            ->Where('company_id = ?',$company_id )->search($search)
            ->addGroupBy('t.name')->addGroupBy('t.value');
        $this->fiscal_invoices = $q->fetchArray();

        $q = ExpenseQuery::create()->innerJoin('i.Items it')->innerJoin('it.Taxes t')
            ->addSelect('t.name as name')->addSelect('t.value as value ')
            ->addSelect('i.id')->addSelect('it.id')->addSelect('t.id') //Necesary for doctrine
            ->addSelect('sum(
        CASE WHEN discount >0
        THEN ((100-it.discount) /100) * (it.unitary_cost * it.quantity)
        ELSE it.unitary_cost * it.quantity
        END ) AS base')

            ->Where('company_id = ?',$company_id )->search($search)
            ->addGroupBy('t.name')->addGroupBy('t.value');
        $this->fiscal_expenses = $q->fetchArray();

        $q = ExpenseQuery::create()->innerJoin('i.Items it')->innerJoin('it.ItemTax itt')->innerJoin('it.Taxes t')->innerJoin('it.ExpenseType et')
            ->addSelect('et.name as name')
            ->addSelect('i.id')->addSelect('it.id')->addSelect('t.id') //Necesary for doctrine
            ->addSelect('sum(
        CASE WHEN discount >0
        THEN ((100-it.discount) /100) * (it.unitary_cost * it.quantity)
        ELSE it.unitary_cost * it.quantity
        END ) AS base')

            ->Where('company_id = ?',$company_id )->search($search)
            ->addGroupBy('et.name');
        $this->detailed_expenses = $q->fetchArray();
        //347
        $q = InvoiceQuery::create()
            ->addSelect('i.customer_name as customer_name')->addSelect('i.customer_identification customer_identification')
            ->addSelect('sum(
               case when MONTH(issue_date) >= 1 and MONTH(issue_date) <= 3 then gross_amount else 0 end) as 1t
            ')
            ->addSelect('sum(
               case when MONTH(issue_date) >= 4 and MONTH(issue_date) <= 6 then gross_amount else 0 end) as 2t
            ')
            ->addSelect('sum(
               case when MONTH(issue_date) >= 7 and MONTH(issue_date) <= 9 then gross_amount else 0 end) as 3t
            ')
            ->addSelect('sum(
               case when MONTH(issue_date) >= 10 and MONTH(issue_date) <= 12 then gross_amount else 0 end) as 4t
            ')
            ->addSelect('sum(gross_amount) as total')
            ->Where('company_id = ?',$company_id )->AndWhere('YEAR(issue_date) = ?',$search['to']['year'])
            ->addGroupBy('i.customer_name')->addGroupBy('i.customer_identification')
            ->having('sum(gross_amount) > 3005.06');
            $this->fiscal_347 = $q->fetchArray();
    }

    $q = InvoiceQuery::create()->Where('company_id = ?',$company_id )->search($search)->limit($this->maxResults);

    $exp = ExpenseQuery::create()->Where('company_id = ?',$company_id )->search($search)->limit($this->maxResults);

    $eqp = EstimateQuery::create()->Where('status = 2')->AndWhere('company_id = ?',$company_id )->search($search)->limit($this->maxResults);

    $eqa = EstimateQuery::create()->Where('status = 3')->AndWhere('company_id = ?',$company_id )->search($search)->limit($this->maxResults);

    $eqr = EstimateQuery::create()->Where('status = 1')->AndWhere('company_id = ?',$company_id )->search($search)->limit($this->maxResults);

    //Expenses total
    $this->epending  = $eqp->total('gross_amount');
    if(empty($this->epending))
        $this->epending = 0;
    $this->eapproved  = $eqa->total('gross_amount');
    if(empty($this->eapproved))
        $this->eapproved = 0;
    $this->erejected  = $eqr->total('gross_amount');
    if(empty($this->erejected))
        $this->erejected = 0;;

    // for the overdue unset the date filters, to show all the overdue
    unset($search['from'], $search['to']);
    $overdueQuery = InvoiceQuery::create()->Where('company_id = ?',$company_id )->search($search)->status(Invoice::OVERDUE);

    // totals
    $this->gross  = $q->total('gross_amount');
    if(empty($this->gross))
        $this->gross = 0;
    $this->due    = $q->total('due_amount');
    if(empty($this->due))
        $this->due = 0;
    $this->paid   = $q->total('paid_amount');
    if(empty($this->paid))
        $this->paid = 0;
    $this->odue   = $overdueQuery->total('due_amount');
    if(empty($this->odue))
        $this->odue = 0;
    $this->taxes  = $q->total('tax_amount');
    if(empty($this->taxes))
        $this->taxes = 0;
    $this->net    = $q->total('net_amount');
    if(empty($this->net))
        $this->net = 0;
    //Expenses  totals
    $this->expense_gross  = $exp->total('gross_amount');
    if(empty($this->expense_gross))
        $this->expense_gross = 0;
    $this->expense_due    = $exp->total('due_amount');
    if(empty($this->expense_due))
        $this->expense_due = 0;
    $this->expense_paid   = $exp->total('paid_amount');
    if(empty($this->expense_paid))
        $this->expense_paid = 0;
    $this->expense_taxes  = $exp->total('tax_amount');
    if(empty($this->expense_taxes))
        $this->expense_taxes = 0;
    $this->expense_net    = $exp->total('net_amount');
    if(empty($this->expense_net))
        $this->expense_net = 0;

    // this is for the redirect of the payments forms
    $this->getUser()->setAttribute('module', $request->getParameter('module'));

    // link counters
    $this->recentCounter  = $q->count();
    $this->overdueCounter = $overdueQuery->count();
    $this->pendingCounter = $eqp->count();
    // recent & overdue invoices
    $this->recent         = $q->execute();
    $this->pending         = $eqp->execute();

    $this->net=$q->total('net_amount');
    $this->expense_net=$exp->total('net_amount');
  }

}
