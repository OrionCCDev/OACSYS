<?php

use App\Http\Controllers\AssetRequestController;
use App\Models\Receive;
use Illuminate\Http\Request;
use App\Livewire\ClientManage;
use App\Imports\SimCardsImport;
use App\Livewire\PositionAdder;
use App\Livewire\ProjectManage;
use App\Livewire\SimCardManage;
use App\Imports\EmployeesImport;
use App\Livewire\DepartmentAdder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReceiveController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\SimCardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClearanceController;
use App\Http\Controllers\ConsultantController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ClientEmployeeController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\EvaluateController;
use App\Http\Controllers\LogisticsUserController;
use Barryvdh\DomPDF\Facade\Pdf;
Route::get('/', function () {
    $employees_count = \App\Models\Employee::count();
    $project_count = \App\Models\Project::count();
    $department_count = \App\Models\Department::count();
    $routers_count = \App\Models\Device::where('device_type', 'Router')->count();
    $laptop_count = \App\Models\Device::where('device_type', 'Laptop')->count();
    $camera_count = \App\Models\Device::where('device_type', 'Camera')->count();
    return view('index', compact('employees_count', 'project_count', 'department_count', 'routers_count', 'laptop_count', 'camera_count'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/import-simcards', function () {
    return view('profile.uploadSimCards');
})->middleware(['auth', 'role:o-super-admin|o-admin']);

Route::get('/update-employees', function () {
    return view('employees.uploadEmployeesUpdated');
})->middleware(['auth', 'role:o-super-admin|o-admin']);

Route::get('/update-sims', [SimCardController::class , 'create'])->middleware(['auth', 'role:o-super-admin|o-admin']);


Route::post('/update-employees', [EmployeeController::class, 'updateEmployees'])
    ->middleware(['auth', 'role:o-super-admin|o-admin'])->name('employees.updateFromExcel');

Route::post('/import-simcards', function (Request $request) {
    Excel::import(new SimCardsImport, $request->file('file'));
    return redirect()->back()->with('success', 'SIM cards imported successfully');
})->middleware(['auth', 'role:o-super-admin|o-admin']);

Route::get('/import-employees', function () {
    return view('profile.uploadExcel');
});

Route::post('/simcards/import', [SimCardController::class, 'import'])->name('simcards.import');

Route::post('/import-employees', function (Request $request) {
    Excel::import(new EmployeesImport, $request->file('file'));
    return redirect()->back()->with('success', 'Employees imported successfully');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//------------------------------------------------
// the right way to do it with middleware---------
//------------------------------------------------
Route::middleware(['web', 'auth'])->group(function () {
    // All routes except 'show' require o-hr, o-super-admin, or o-admin role
    Route::middleware(['role:o-hr|o-super-admin|o-admin'])->group(function () {
        Route::resource('manager', ManagerController::class)
            ->except(['show']);
    });
    Route::middleware(['role:lo-manager|o-super-admin|o-admin'])->group(function () {
        Route::resource('logistics', LogisticsUserController::class);
    });

    // 'show' route allows managers as well
    Route::middleware(['role:o-hr|o-super-admin|o-admin|o-manager'])->group(function () {
        Route::resource('manager', ManagerController::class)
            ->only(['show']);

        Route::put('/password/update', [ManagerController::class, 'updatePW'])->name('password.Manager.update');

        Route::resource('/employees', EmployeeController::class);
        Route::get('/employees/{id}/print', [EmployeeController::class, 'generatePrintablePdf'])->name('employees.print');
        Route::resource('/evaluations', EvaluateController::class);
        Route::resource('/asset-request', AssetRequestController::class);

        Route::post('/request/{id}/upload-signature',[AssetRequestController::class , 'uploadSignature'])->name('asset-request.upload-signature');
        Route::patch('/asset-request/{id}/approve', [AssetRequestController::class, 'approve'])->name('asset-request.approve');
        Route::patch('/asset-request/{id}/reject', [AssetRequestController::class, 'reject'])->name('asset-request.reject');

        Route::resource('/deductions', DeductionController::class);

        Route::get('/deductions/employee/{id}', [DeductionController::class , 'showEmployeeDeductions'])->name('deduction.showEmployeeDeduction');
        Route::get('/deductions/employee/{id}/make', [DeductionController::class , 'createNewDeduct'])->name('deductions.createNewDeduct');
        Route::get('deductions/print/{id}', [DeductionController::class, 'showDeductionReport'])->name('deductions.showDeductionReport');
        Route::post('deductions/upload/signed/{id}', [DeductionController::class, 'uploadSignedDeduction'])->name('deductions.upload-signed');

    });
});
//------------------------------------------------
// the right way to do it with middleware---------
//------------------------------------------------
// Route::middleware(['auth', 'role:o-hr|o-super-admin|o-admin|o-manager'])->group(function () {
//     // Route::get('/manager', [ManagerController::class, 'index'])->name('manager.index');
//     // Route::get('/manager', [ManagerController::class, 'show'])->name('manager.show');

//     // Route::get('/company-qr', [QRCodeController::class, 'generateCompanyQR'])->name('company.qr');
//     // Route::get('/links', [QRCodeController::class, 'showLinks'])->name('links');
//     // Route::get('/qrcode', [QRCodeController::class, 'generateQR']);
// // Route::post('/company-qr/store', [QRCodeController::class, 'store'])->name('company.qr.store');
// });

Route::middleware(['auth', 'role:o-super-admin|o-admin'])->group(function () {
    Route::resource('/clientEmployee', ClientEmployeeController::class);
    Route::resource('/consultant', ConsultantController::class);

    Route::resource('/device', DeviceController::class);
    Route::resource('/simCard', SimCardController::class);
    // Route::get('/receive/make/{devices}/{receiver_id}/{receiver_type}/{receive_id}/{rcv_id}', [ReceiveController::class, 'make'])->name('receive.make');

    Route::get('/project/{id}/details', [ProjectController::class, 'show'])->name('project.details');


    Route::put('/project/client/{client}/remove', [ProjectController::class, 'removeClient'])->name('project.removeClient');
    Route::put('/project/client/{client}/transfer',  [ProjectController::class, 'transferClient'])->name('project.transferClient');
    Route::post('/project/add/{id}', [ProjectController::class, 'addClient'])->name('project.addClient');
    Route::put('/project/consultant/{consultant}/remove', [ProjectController::class, 'removeConsultant'])->name('project.removeConsultant');
    Route::put('/project/consultant/{consultant}/transfer',  [ProjectController::class, 'transferConsultant'])->name('project.transferConsultant');
    Route::post('/project/add/consultant/{id}', [ProjectController::class, 'addConsultant'])->name('project.addConsultant');



// Receiving routes
Route::get('project/receives/create/{project_id}', [ReceiveController::class, 'createRproject'])->name('project.receives.create');
Route::post('project/receives/finish/{id}', [ReceiveController::class, 'finishRproject'])->name('project.receive.finish');
Route::delete('project/receives/{receive}', [ReceiveController::class, 'destroyRproject'])->name('project.receive.destroy');

    Route::get('/project/{id}/add/employees', [ProjectController::class, 'addEmployeeProject'])->name('project.addEmployeeProject');
    Route::get('/project/{id}/recive/devices', [ProjectController::class, 'makeReciveProjectDevice'])->name('project.device_on_project_details');
    Route::get('/project/{id}/add/devices', [ProjectController::class, 'addDevices'])->name('project.addDevice');
    Route::post('/project/add/devices', [ProjectController::class, 'storeDevices'])->name('project.addDevicesToProject');



    Route::get('/client', ClientManage::class)->name('client.index');

    // Project Asset Management Routes
    Route::prefix('project-assets')->name('project-assets.')->group(function () {
        Route::get('/', [\App\Http\Controllers\ProjectAssetController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\ProjectAssetController::class, 'show'])->name('show');

        // Receive Routes
        Route::get('/{projectId}/receive/create', [\App\Http\Controllers\ProjectAssetController::class, 'createReceive'])->name('receive.create');
        Route::post('/{projectId}/receive/store', [\App\Http\Controllers\ProjectAssetController::class, 'storeReceive'])->name('receive.store');
        Route::get('/receive/{receiveId}/finish', [\App\Http\Controllers\ProjectAssetController::class, 'finishReceive'])->name('receive.finish');
        Route::post('/receive/{receiveId}/complete', [\App\Http\Controllers\ProjectAssetController::class, 'completeReceive'])->name('receive.complete');

        // Clearance Routes
        Route::get('/{projectId}/clearance/create', [\App\Http\Controllers\ProjectAssetController::class, 'createClearance'])->name('clearance.create');
        Route::post('/{projectId}/clearance/store', [\App\Http\Controllers\ProjectAssetController::class, 'storeClearance'])->name('clearance.store');
        Route::get('/clearance/{clearanceId}/finish', [\App\Http\Controllers\ProjectAssetController::class, 'finishClearance'])->name('clearance.finish');
        Route::post('/clearance/{clearanceId}/complete', [\App\Http\Controllers\ProjectAssetController::class, 'completeClearance'])->name('clearance.complete');

        // Transfer Routes
        Route::get('/{projectId}/transfer/create', [\App\Http\Controllers\ProjectAssetController::class, 'createTransfer'])->name('transfer.create');
        Route::post('/{projectId}/transfer/store', [\App\Http\Controllers\ProjectAssetController::class, 'storeTransfer'])->name('transfer.store');
        Route::get('/transfer/{transferId}/finish', [\App\Http\Controllers\ProjectAssetController::class, 'finishTransfer'])->name('transfer.finish');
        Route::post('/transfer/{transferId}/complete', [\App\Http\Controllers\ProjectAssetController::class, 'completeTransfer'])->name('transfer.complete');
        Route::get('/transfer/{transferId}/view', [\App\Http\Controllers\ProjectAssetController::class, 'viewTransfer'])->name('transfer.view');
    });

});
Route::middleware(['auth', 'role:o-hr|o-super-admin|o-admin'])->group(function () {
    // Route::resource('department' , DepartmentController::class );
    Route::resource('/clearance', ClearanceController::class);
    Route::resource('/receive', ReceiveController::class);
    Route::resource('/employees', EmployeeController::class)->except(['show']);
    Route::get('/resign/employee/{id}', [EmployeeController::class, 'preResign'])->name('employee.preResign');
    Route::get('/device/employee/assign', [DeviceController::class, 'assignDeviceToEmp'])->name('device.assignDeviceToEmp');
    Route::post('/device/employee/assign', [DeviceController::class, 'storeAssignDeviceToEmp'])->name('device.storeAssignDeviceToEmp');
    Route::put('/device/{device}/unassign', [DeviceController::class, 'unassign'])->name('device.unassign');
    Route::post('/device/{device}/assign', [DeviceController::class, 'assign'])->name('device.assign');
    Route::get('/employee/search', [EmployeeController::class, 'search'])->name('employee.search');
    Route::post('/resign/employee/{id}/clearance/{clr}', [EmployeeController::class, 'finishResign'])->name('employee.resign-upload-signature');
    Route::post('/clearance/{id}/upload-signature', [ClearanceController::class, 'uploadSignature'])
        ->name('clearance.upload-signature');
    Route::get('/employee/receives/{id}', [EmployeeController::class, 'showReceives'])->name('employee.receives');
    Route::get('/employee/receive/{id}', [EmployeeController::class, 'showReceiveDetails'])->name('employee.receive.detail');
    Route::get('/employee/clearance/details/{id}', [EmployeeController::class, 'showClearanceDetails'])->name('employee.clearance.detail');
    Route::get('/employee/clearances/{id}', [EmployeeController::class, 'showClearances'])->name('employee.clearances');
    Route::get('/employee/history/{id}', [EmployeeController::class, 'showHistory'])->name('employee.history');
    Route::get('/clearance/{clearance}/cancel', [ClearanceController::class, 'cancel'])->name('clearance.cancel');
    Route::get('/clearance/select/{id}/{type}', [ClearanceController::class, 'selectDevicesAndSimCards'])->name('clearance.devices');
    Route::post('/clearance/selected-devices-and-simcards', [ClearanceController::class, 'selectedDevicesAndSimCardsToMakeClearance'])->name('clearance.selectedDevicesAndSimCardsToMakeClearance');
    Route::get('/receive/make/{devices?}/{receiver_id}/{receiver_type}/{receive_id}/{rcv_id}/{simCards?}', [ReceiveController::class, 'make'])->name('receive.make');
    Route::post('/up/receive/image/{id}', [ReceiveController::class, 'finish'])->name('receive.finish');
    Route::put('/transfer/employee', [ProjectController::class, 'transfer'])->name('employee.transfer');
    Route::get('/department', DepartmentAdder::class)->name('department.index');
    Route::get('/cancel/device/{id}', [ReceiveController::class, 'cancel'])->name('receive.cancel');
    Route::get('/complete/cancel/{id}', [ReceiveController::class, 'pendingCancel'])->name('comp.clear');
    Route::post('/device/{id}/{clear}', [ReceiveController::class, 'clear'])->name('device.clear');
    Route::get('/position', PositionAdder::class)->name('position.index');
    Route::get('/project', ProjectManage::class)->name('project.index');
    Route::get('/sim', SimCardManage::class)->name('sim.index');
});

// QR Code routes

Route::get('/generate-qr', [QrCodeController::class, 'generateFixedQr'])->name('generate.qr');
Route::get('/fixed-qr', [QrCodeController::class, 'showFixedQr'])->name('show.qr');
Route::get('/qr-redirect', [QrCodeController::class, 'handleRedirect'])->name('qr.redirect');
require __DIR__ . '/auth.php';
