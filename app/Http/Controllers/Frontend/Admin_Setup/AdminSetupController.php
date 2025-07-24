<?php

namespace App\Http\Controllers\Frontend\Admin_Setup;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminSetupController extends Controller
{
    /////////////////////////// --------------- Company Methods start---------- //////////////////////////
    // Show Companies
    public function ShowCompanies(Request $req){
        $name = "Company Details";
        $js = "company";
        if ($req->ajax()) {
            return view('admin_setup.company.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.company.main', compact('name', 'js'));
        }
    } // End Method





    /////////////////////////// --------------- Company Type Table Methods start ---------- //////////////////////////
    // Show All Company Type
    public function ShowCompanyType(Request $req){
        $name = "Company Type";
        $js = 'admin_setup/company_type';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method





    /////////////////////////// --------------- Bank Methods start---------- //////////////////////////
    // Show All Bank Details
    public function ShowBanks(Request $req){
        $name = "Bank Details";
        if ($req->ajax()) {
            return view('admin_setup.bank.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.bank.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Location Table Methods start ---------- //////////////////////////
    // Show All Locations
    public function ShowLocations(Request $req){
        $name = "Location";
        if ($req->ajax()) {
            return view('admin_setup.location.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.location.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Store Table Methods start ---------- //////////////////////////
    // Show Store Details
    public function ShowStores(Request $req){
        $name = "Store Details";
        if ($req->ajax()) {
            return view('admin_setup.store.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.store.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Payment Method Table Methods start ---------- //////////////////////////
    // Show All Payment Method
    public function ShowPaymentMethod(Request $req){
        $name = "Payment Method";
        $js = 'admin_setup/payment_method';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method
    
    
    
    /////////////////////////// --------------- Transaction Main Head Table Methods start ---------- //////////////////////////
    // Show All Transaction Main Head
    public function ShowTransactionMainHead(Request $req){
        $name = "Transaction Main Head";
        $js = 'admin_setup/main_head';
        if ($req->ajax()) {
            return view('common_modals.single_input.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('common_modals.single_input.main', compact('name', 'js'));
        }
    } // End Method



     /////////////////////////// --------------- Show Corporate Table Methods start ---------- //////////////////////////
    
    public function ShowCorporate(Request $req){
        $name = "Corporate";
        $js = 'admin_setup/corporate';
        if ($req->ajax()) {
            return view('admin_setup.corporate.ajaxBlade', compact('name', 'js'));
        }
        else{
            return view('admin_setup.corporate.main', compact('name', 'js'));
        }
    } // End Method






    /////////////////////////// --------------- Tran With Table Methods start ---------- //////////////////////////
    // Show All TranWith
    public function ShowTranWith(Request $req){
        $name = "User Type";
        if ($req->ajax()) {
            return view('admin_setup.tran_with.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.tran_with.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Transaction Groupe Table Methods start ---------- //////////////////////////
    // Show All Transaction Groupes
    public function ShowTransactionGroupes(Request $req){
        $name = "Transaction Groupe";
        if ($req->ajax()) {
            return view('admin_setup.tran_groupe.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.tran_groupe.main', compact('name'));
        }
    } // End Method





    /////////////////////////// --------------- Transaction Heads Table Methods start ---------- //////////////////////////
    // Show All Transaction Heads
    public function ShowTransactionHeads(Request $req){
        $name = "Transaction Head";
        if ($req->ajax()) {
            return view('admin_setup.tran_head.ajaxBlade', compact('name'));
        }
        else{
            return view('admin_setup.tran_head.main', compact('name'));
        }
    } // End Method
}
