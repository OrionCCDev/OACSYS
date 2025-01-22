<?php

use App\Http\Controllers\ClearanceController;
use App\Http\Controllers\ClientEmployeeController;
use Illuminate\Http\Request;
use App\Livewire\ClientManage;
use App\Livewire\PositionAdder;
use App\Livewire\SimCardManage;
use App\Imports\EmployeesImport;
use App\Livewire\DepartmentAdder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SimCardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReceiveController;
use App\Livewire\ProjectManage;


Route::get('/', function () {
    $employees_count = \App\Models\Employee::count();
    return view('index' , compact('employees_count'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/import-employees', function() {
    return view('profile.uploadExcel');
});

Route::post('/import-employees', function(Request $request) {
    Excel::import(new EmployeesImport, $request->file('file'));
    return redirect()->back()->with('success', 'Employees imported successfully');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // Route::resource('department' , DepartmentController::class );
    Route::resource('/clientEmployee' , ClientEmployeeController::class);
    Route::resource('/clearance' , ClearanceController::class);
    Route::resource('/employees' , EmployeeController::class);
    Route::resource('/receive' , ReceiveController::class);
    Route::resource('/device' , DeviceController::class);
    Route::get('/receive/make/{devices}/{receiver_id}/{receiver_type}/{receive_id}/{rcv_id}', [ReceiveController::class, 'make'])->name('receive.make');
    Route::post('/up/receive/image/{id}' , [ReceiveController::class , 'finish'])->name('receive.finish');
    Route::get('/project/{id}/details' , [ProjectController::class , 'show'])->name('project.details');
    Route::put('/transfer/employee' , [ProjectController::class , 'transfer'])->name('employee.transfer');
    Route::get('/department' , DepartmentAdder::class)->name('department.index');
    Route::get('/cancel/device/{id}' , [ReceiveController::class , 'cancel'])->name('receive.cancel');
    Route::get('/complete/cancel/{id}' , [ReceiveController::class , 'pendingCancel'])->name('comp.clear');
    Route::post('/device/{id}/{clear}' , [ReceiveController::class , 'clear'])->name('device.clear');
    Route::get('/position' , PositionAdder::class)->name('position.index');
    Route::get('/project' , ProjectManage::class)->name('project.index');
    Route::get('/client' , ClientManage::class)->name('client.index');
    Route::get('/sim' , SimCardManage::class)->name('sim.index');
    Route::get('/resign/employee/{id}' , [EmployeeController::class , 'preResign'])->name('employee.preResign');
    Route::post('/resign/employee/{id}/clearance/{clr}' , [EmployeeController::class , 'finishResign'])->name('employee.resign-upload-signature');
    Route::post('/clearance/{id}/upload-signature', [ClearanceController::class, 'uploadSignature'])
    ->name('clearance.upload-signature');
    Route::get('/clearance/{clearance}/cancel', [ClearanceController::class, 'cancel'])->name('clearance.cancel');
});


require __DIR__.'/auth.php';
