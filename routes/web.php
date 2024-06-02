<?php

use App\Http\Controllers\CompanyContact;
use App\Http\Controllers\CompanyInfo;
use App\Http\Controllers\CompanyInfoController;
use App\Http\Controllers\CompanyContactController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });



// for dashboard
Route::get('/',[DashboardController::class, 'dashboard'])->name('/');

// company_info
Route::get('/company-info', [CompanyInfoController::class, 'indexcompanyInfo'])->name('company-info.index');
Route::post('/company-info/create', [CompanyInfoController::class, 'createCompanyInfo'])->name('company-info.create');
Route::get('/company-info/list', [CompanyInfoController::class, 'listCompanyInfo'])->name('company-info.list');
Route::get('/company-info/edit/{id}', [CompanyInfoController::class, 'editCompanyInfo'])->name('company-info.edit');
Route::post('/company-info/update/{id}', [CompanyInfoController::class, 'updateCompanyInfo'])->name('company-info.update');
Route::delete('/company-info/delete/{id}', [CompanyInfoController::class, 'deleteCompanyInfo'])->name('company-info.delete');

// company_contact
Route::get('/company-contact', [CompanyContactController::class, 'IndexcompanyContact'])->name('company-contact.index');
Route::post('/company-contact/create', [CompanyContactController::class, 'createCompanyContact'])->name('company-contact.create');
Route::get('/company-contact/list', [CompanyContactController::class, 'ListCompanyContact'])->name('company-contact.list');
Route::get('/company-contact/edit/{id}', [CompanyContactController::class, 'editCompanyContact'])->name('company-contact.edit');
Route::post('/company-contact/update/{id}', [CompanyContactController::class, 'updateCompanyContact'])->name('company-contact.update');
Route::get('/company-contact/delete/{id}', [CompanyContactController::class, 'deleteCompanyContact'])->name('company-contact.delete');

