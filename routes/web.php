<?php

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use PragmaGoTech\Interview\Model\LoanProposal;
use PragmaGoTech\Interview\Model\Calculator;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('main');
});

Route::get('/calculate', function (Request $request) {
    $loanAmount = $request->input('amount');
    if (!$loanAmount || $loanAmount < 1000 || $loanAmount > 20000) {
        $jsonData = ['success' => false, 'message' => 'Your amount need to be between 1000 and 20000'];
        return Response::json($jsonData, 400);
    }

    // Open a Fee Calculator and define Loan Proposal
    $calculator = new Calculator();
    $application = new LoanProposal($loanAmount);

    $jsonData = ['success' => true, 'fee' => (float)$calculator->calculate($application)];
    return Response::json($jsonData, 200);
})->name('calculate');