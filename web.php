<?php

use App\Http\Controllers\Account;
use App\Http\Controllers\ActionlogController;
use App\Http\Controllers\Api\ImportController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\BulkCategoriesController;
use App\Http\Controllers\BulkManufacturersController;
use App\Http\Controllers\BulkSuppliersController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentsController;
use App\Http\Controllers\DepreciationsController;
use App\Http\Controllers\GroupsController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\LabelsController;
use App\Http\Controllers\UploadedFilesController;
use App\Http\Controllers\ManufacturersController;
use App\Http\Controllers\ModalController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportTemplatesController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SetupController;
use App\Http\Controllers\StatuslabelsController;
use App\Http\Controllers\SuppliersController;
use App\Http\Controllers\ViewAssetsController;
use App\Livewire\Importer;
use App\Models\ReportTemplate;
use Illuminate\Support\Facades\Route;
use Tabuna\Breadcrumbs\Trail;

Route::group(['middleware' => 'auth'], function () {
    /*
    * Companies
    */
    Route::resource('companies', CompaniesController::class, [
        'parameters' => ['company' => 'company_id'],
    ]);

    /*
    * Categories
    */
    Route::resource('categories', CategoriesController::class, [
        'parameters' => ['category' => 'category_id'],
    ]);

    Route::post('categories/bulk/delete', [BulkCategoriesController::class, 'destroy'])->name('categories.bulk.delete');

    /*
    * Labels
    */
    Route::get(
        'labels/{labelName}',
        [LabelsController::class, 'show']
    )->where('labelName', '.*')->name('labels.show');

    Route::get('/test-email', function () {
        $mailable = new \App\Mail\CheckoutComponentMail(

        );
        return $mailable->render(); // dumps HTML
    });
    /*
    * Manufacturers
    */

    Route::group(['prefix' => 'manufacturers', 'middleware' => ['auth']], function () {
        Route::post('{manufacturers_id}/restore', [ManufacturersController::class, 'restore'] )->name('restore/manufacturer');
        Route::post('seed', [ManufacturersController::class, 'seed'] )->name('manufacturers.seed');


    });

    Route::resource('manufacturers', ManufacturersController::class);

    Route::post('manufacturers/bulk/delete', [BulkManufacturersController::class, 'destroy'])->name('manufacturers.bulk.delete');

    /*
    * Suppliers
    */
    Route::resource('suppliers', SuppliersController::class);

    Route::post('suppliers/bulk/delete', [BulkSuppliersController::class, 'destroy'])->name('suppliers.bulk.delete');

    /*
    * Depreciations
     */
    Route::resource('depreciations', DepreciationsController::class);

    /*
    * Status Labels
     */
    Route::resource('statuslabels', StatuslabelsController::class);

    /*
    * Departments
    */
    Route::resource('departments', DepartmentsController::class);
});

/*
|
|--------------------------------------------------------------------------
| Re-Usable Modal Dialog routes.
|--------------------------------------------------------------------------
|
| Routes for various modal dialogs to interstitially create various things
|
*/

Route::group(['middleware' => 'auth', 'prefix' => 'modals'], function () {
    Route::get('{type}/{itemId?}', [ModalController::class, 'show'] )->name('modal.show');
});

/*
|--------------------------------------------------------------------------
| Log Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get(
        'display-sig/{filename}',
        [ActionlogController::class, 'displaySig']
    )->name('log.signature.view');
    Route::get(
        'stored-eula-file/{filename}',
        [ActionlogController::class, 'getStoredEula']
    )->name('log.storedeula.download');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Register all the admin routes.
|
*/

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'authorize:superuser']], function () {

    Route::get('settings', [SettingsController::class, 'getSettings'])
        ->name('settings.general.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.general_title'), route('settings.general.index')));

    Route::post('settings', [SettingsController::class, 'postSettings'])
        ->name('settings.general.save');

    Route::get('branding', [SettingsController::class, 'getBranding'])
        ->name('settings.branding.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.branding_title'), route('settings.branding.index')));

    Route::post('branding', [SettingsController::class, 'postBranding'])
        ->name('settings.branding.save');

    Route::get('security', [SettingsController::class, 'getSecurity'])
        ->name('settings.security.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.security_title'), route('settings.security.index')));

    Route::post('security', [SettingsController::class, 'postSecurity'])
        ->name('settings.security.save');

    Route::get('localization', [SettingsController::class, 'getLocalization'])
        ->name('settings.localization.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.localization_title'), route('settings.localization.index')));

    Route::post('localization', [SettingsController::class, 'postLocalization'])
        ->name('settings.localization.save');

    Route::get('notifications', [SettingsController::class, 'getAlerts'])
        ->name('settings.alerts.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.alert_title'), route('settings.alerts.index')));

    Route::post('notifications', [SettingsController::class, 'postAlerts'])
        ->name('settings.alerts.save');

    Route::get('slack', [SettingsController::class, 'getSlack'])
        ->name('settings.slack.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.webhook_title'), route('settings.slack.index')));

    Route::post('slack', [SettingsController::class, 'postSlack'])
        ->name('settings.slack.save');

    Route::get('asset_tags', [SettingsController::class, 'getAssetTags'])
        ->name('settings.asset_tags.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.asset_tag_title'), route('settings.asset_tags.index')));

    Route::post('asset_tags', [SettingsController::class, 'postAssetTags'])
        ->name('settings.asset_tags.save');

    Route::get('labels', [SettingsController::class, 'getLabels'])
        ->name('settings.labels.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.labels_title'), route('settings.labels.index')));

    Route::post('labels', [SettingsController::class, 'postLabels'])
        ->name('settings.labels.save');

    Route::get('ldap', [SettingsController::class, 'getLdapSettings'])
        ->name('settings.ldap.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.ldap_ad'), route('settings.ldap.index')));

    Route::post('ldap', [SettingsController::class, 'postLdapSettings'])
        ->name('settings.ldap.save');

    Route::get('phpinfo', [SettingsController::class, 'getPhpInfo'])
        ->name('settings.phpinfo.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.php_info'), route('settings.phpinfo.index')));

    Route::get('oauth', [SettingsController::class, 'api'])
        ->name('settings.oauth.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.oauth'), route('settings.oauth.index')));

    Route::get('google', [SettingsController::class, 'getGoogleLoginSettings'])
        ->name('settings.google.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.google_login'), route('settings.google.index')));

    Route::post('google', [SettingsController::class, 'postGoogleLoginSettings'])
        ->name('settings.google.save');

    Route::get('purge', [SettingsController::class, 'getPurge'])
        ->name('settings.purge.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.purge'), route('settings.purge.index')));

    Route::post('purge', [SettingsController::class, 'postPurge'])
        ->name('settings.purge.save');

    Route::get('login-attempts', [SettingsController::class, 'getLoginAttempts'])
        ->name('settings.logins.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.login'), route('settings.logins.index')));


    // SAML
    Route::get('/saml', [SettingsController::class, 'getSamlSettings'])
        ->name('settings.saml.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('settings.index')
            ->push(trans('admin/settings/general.saml_title'), route('settings.saml.index')));

    Route::post('/saml', [SettingsController::class, 'postSamlSettings'])
        ->name('settings.saml.save');




    // Backups
    Route::group(['prefix' => 'backups', 'middleware' => 'auth'], function () {
        Route::get('download/{filename}',
            [SettingsController::class, 'downloadFile'])->name('settings.backups.download');

        Route::delete('delete/{filename}',
            [SettingsController::class, 'deleteFile'])->name('settings.backups.destroy');

        Route::post('/',
            [SettingsController::class, 'postBackups']
        )->name('settings.backups.create');

        Route::post('/restore/{filename}',
            [SettingsController::class, 'postRestore']
        )->name('settings.backups.restore');

        Route::post('/upload',
            [SettingsController::class, 'postUploadBackup']
        )->name('settings.backups.upload');

        // Handle redirect from after POST request from backup restore
        Route::get('/restore/{filename?}', function () {
            return redirect(route('settings.backups.index'));
        });

        Route::get('/', [SettingsController::class, 'getBackups'])
            ->name('settings.backups.index')
            ->breadcrumbs(fn (Trail $trail) =>
            $trail->parent('settings.index')
                ->push(trans('admin/settings/general.backups'), route('settings.backups.index')));
    });

    Route::resource('groups', GroupsController::class);


    /**
     * This breadcrumb is repeated for groups in the BreadcrumbServiceProvider, since groups uses resource routes
     * and that servcie provider cannot see the breadcrumbs defined below
     */
    Route::get('/', [SettingsController::class, 'index'])
        ->name('settings.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.admin'), route('settings.index')));
});

/*
|--------------------------------------------------------------------------
| Importer Routes
|--------------------------------------------------------------------------
|
|
|
*/

Route::group(['prefix' => 'import', 'middleware' => ['auth']], function () {

    Route::get('download/{import}',
        [
            UploadedFilesController::class,
            'downloadImport'
        ]
    )->name('imports.download');

    Route::livewire('/', Importer::class)
        ->middleware('auth')
        ->name('imports.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.import'), route('imports.index')));

});


/*
|--------------------------------------------------------------------------
| Account Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group(['prefix' => 'account', 'middleware' => ['auth']], function () {

    // Profile
    Route::get('profile', [ProfileController::class, 'getIndex'])
        ->name('profile')
        ->breadcrumbs(fn (Trail $trail) =>
                $trail->parent('home')
            ->push(trans('general.editprofile'), route('profile')));

    Route::post('profile', [ProfileController::class, 'postIndex'])
        ->name('profile.update');

    Route::get('menu', [ProfileController::class, 'getMenuState'])
        ->name('account.menuprefs');

    Route::get('password', [ProfileController::class, 'password'])
        ->name('account.password.index')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.profile'), route('account'))
            ->push(trans('general.changepassword'), route('account.password.index')));

    Route::post('password', [ProfileController::class, 'passwordSave'])
        ->name('account.password.update');

    Route::get('api', [ProfileController::class, 'api'])
        ->name('user.api')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.profile'), route('account'))
            ->push(trans('general.manage_api_keys'), route('user.api')));

    // View Assets
    Route::get('view-assets', [ViewAssetsController::class, 'getIndex'])
        ->name('view-assets')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.profile'), route('account'))
            ->push(trans('general.viewassets'), route('view-assets')));

    Route::get('requested', [ViewAssetsController::class, 'getRequestedAssets'])
        ->name('account.requested')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.profile'), route('account'))
            ->push(trans('general.requested_assets_menu'), route('account.requested')));

    Route::get(
        'requestable-assets', [ViewAssetsController::class, 'getRequestableIndex'])
        ->name('requestable-assets')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.requestable_items'), route('requestable-assets')));


    Route::post('request-asset/{asset}', [ViewAssetsController::class, 'store'])
        ->name('account.request-asset');

    Route::post('request-asset/{asset}/cancel', [ViewAssetsController::class, 'destroy'])
        ->name('account.request-asset.cancel');

    Route::post('request/{itemType}/{itemId}/{cancel_by_admin?}/{requestingUser?}', [ViewAssetsController::class, 'getRequestItem'])
        ->name('account/request-item');

    Route::get(
        'display-sig/{filename}',
        [ProfileController::class, 'displaySig']
    )->name('profile.signature.view');

    Route::get(
        'stored-eula-file/{filename}',
        [ProfileController::class, 'getStoredEula']
    )->name('profile.storedeula.download');

    // Account Dashboard
    Route::get('/', [ViewAssetsController::class, 'getIndex'])
        ->name('account');

    Route::get('accept', [Account\AcceptanceController::class, 'index'])
        ->name('account.accept')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.profile'), route('account'))
            ->push(trans('general.accept_items'), route('account.accept')));

    Route::get('accept/{id}', [Account\AcceptanceController::class, 'create'])
        ->name('account.accept.item')
        ->breadcrumbs(fn (Trail $trail, $id) =>
        $trail->parent('home')
            ->push(trans('general.profile'), route('account'))
            ->push(trans('general.accept_item'), route('account.accept.item', $id)));

    Route::post('accept/{id}', [Account\AcceptanceController::class, 'store'])
        ->name('account.store-acceptance');

    Route::get(
        'print',
        [
            ProfileController::class,
            'printInventory'
        ]
    )->name('profile.print');

    Route::post(
        'email',
        [
            ProfileController::class,
            'emailAssetList'
        ]
    )->name('profile.email_assets');

});

Route::group(['middleware' => ['auth']], function () {
    Route::post('notes', [NotesController::class, 'store'])->name('notes.store');
});

Route::group(['prefix' => 'reports', 'middleware' => ['auth']], function () {

    Route::get('audit', [ReportsController::class, 'audit'])
        ->name('reports.audit')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.audit_report'), route('reports.audit')));

    Route::get(
        'depreciation', [ReportsController::class, 'getDeprecationReport'])
        ->name('reports/depreciation')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.depreciation_report'), route('reports/depreciation')));


    // Is this still used??
    Route::get(
        'export/depreciation', [ReportsController::class, 'exportDeprecationReport'])
        ->name('reports/export/depreciation')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.depreciation_report'), route('reports.audit')));

    Route::get(
        'maintenances', [ReportsController::class, 'getMaintenancesReport'])
        ->name('ui.reports.maintenances')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.asset_maintenance_report'), route('ui.reports.maintenances')));

    // Is this still used?
    Route::get('export/maintenances', [ReportsController::class, 'exportMaintenancesReport'])
        ->name('reports/export/maintenances')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.asset_maintenance_report'), route('reports/export/maintenances')));

    Route::get('licenses', [ReportsController::class, 'getLicenseReport'])
        ->name('reports/licenses')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.license_report'), route('reports/licenses')));

    Route::get('export/licenses', [ReportsController::class, 'exportLicenseReport'])
        ->name('reports/export/licenses');

    Route::get('accessories', [ReportsController::class, 'getAccessoryReport'])
        ->name('reports/accessories');

    Route::get('export/accessories', [ReportsController::class, 'exportAccessoryReport'])
        ->name('reports/export/accessories');

    Route::get('custom', [ReportsController::class, 'getCustomReport'])
        ->name('reports/custom')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.custom_report'), route('reports/custom')));

    Route::post('custom', [ReportsController::class, 'postCustom'])
        ->name('reports.post-custom');


    Route::prefix('templates')
        ->group(function () {

            Route::post('/', [ReportTemplatesController::class, 'store'])
                ->name('report-templates.store');

            // The breadcrumb on this is a little odd for now since we don't have a template index
            Route::get('/{reportTemplate}', [ReportTemplatesController::class, 'show'])
                ->name('report-templates.show')
                ->breadcrumbs(fn (Trail $trail, ReportTemplate $reportTemplate) =>
                $trail->parent('reports/custom')
                    ->push($reportTemplate->name, null)
                    ->push(trans('general.customize_report'), ''));

            Route::get('/{reportTemplate}/edit', [ReportTemplatesController::class, 'edit'])
                ->name('report-templates.edit')
                ->breadcrumbs(fn (Trail $trail, ReportTemplate $reportTemplate) =>
                $trail->parent('reports/custom')
                    ->push($reportTemplate->name, route('report-templates.show', $reportTemplate))
                    ->push(trans('general.customize_report'), ''));


            Route::post('/{reportTemplate}', [ReportTemplatesController::class, 'update'])
                ->name('report-templates.update');

            Route::delete('/{reportTemplate}', [ReportTemplatesController::class, 'destroy'])
                ->name('report-templates.destroy');
    });



    Route::get(
        'activity', [ReportsController::class, 'getActivityReport'])
        ->name('reports.activity')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.activity_report'), route('reports.activity')));

    Route::post('activity', [ReportsController::class, 'postActivityReport'])
        ->name('reports.activity.post');

    Route::get('unaccepted_assets/{deleted?}', [ReportsController::class, 'getAssetAcceptanceReport'])
        ->name('reports/unaccepted_assets')
        ->breadcrumbs(fn (Trail $trail) =>
        $trail->parent('home')
            ->push(trans('general.unaccepted_asset_report'), route('reports/unaccepted_assets')));

    Route::post('unaccepted_assets/sent_reminder', [ReportsController::class, 'sentAssetAcceptanceReminder'])
        ->name('reports/unaccepted_assets_sent_reminder');

    Route::delete('unaccepted_assets/{acceptanceId}/delete', [ReportsController::class, 'deleteAssetAcceptance'])
        ->name('reports/unaccepted_assets_delete');

    Route::post(
        'unaccepted_assets/{deleted?}', [ReportsController::class, 'postAssetAcceptanceReport'])
        ->name('reports/export/unaccepted_assets');

});


Route::get(
    'auth/signin',
    [LoginController::class, 'legacyAuthRedirect']
);


/*
|--------------------------------------------------------------------------
| Setup Routes
|--------------------------------------------------------------------------
|
|
|
*/
Route::group(['prefix' => 'setup', 'middleware' => 'web'], function () {
    Route::get(
        'user',
        [SetupController::class, 'getSetupUser']
    )->name('setup.user');

    Route::post(
        'user',
        [SetupController::class, 'postSaveFirstAdmin']
    )->name('setup.user.save');


    Route::post(
        'migrate',
        [SetupController::class, 'SetupMigrate']
    )->name('setup.migrate');


    Route::get(
        'done',
        [SetupController::class, 'getSetupDone']
    )->name('setup.done');

    Route::get(
        'mailtest',
        [SettingsController::class, 'ajaxTestEmail']
    )->name('setup.mailtest');

    Route::get(
        '/',
        [SetupController::class, 'getSetupIndex']
    )->name('setup');
});





Route::group(['middleware' => 'web'], function () {

    Route::get(
        'login',
        [LoginController::class, 'showLoginForm']
    )->name("login");

    Route::post(
        'login',
        [LoginController::class, 'login']
    );

    Route::get(
        'two-factor-enroll',
        [LoginController::class, 'getTwoFactorEnroll']
    )->name('two-factor-enroll');

    Route::get(
        'two-factor',
        [LoginController::class, 'getTwoFactorAuth']
    )->name('two-factor');

    Route::post(
        'two-factor',
        [LoginController::class, 'postTwoFactorAuth']
    );

    Route::post(
        'password/email',
        [ForgotPasswordController::class, 'sendResetLinkEmail']
    )->name('password.email')->middleware('throttle:forgotten_password');

    Route::get(
        'password/reset',
        [ForgotPasswordController::class, 'showLinkRequestForm']
    )->name('password.request')->middleware('throttle:forgotten_password');


    Route::post(
        'password/reset',
        [ResetPasswordController::class, 'reset']
    )->name('password.update')->middleware('throttle:forgotten_password');

    Route::get(
        'password/reset/{token}',
        [ResetPasswordController::class, 'showResetForm']
    )->name('password.reset');


    Route::post(
        'password/email',
        [ForgotPasswordController::class, 'sendResetLinkEmail']
    )->name('password.email')->middleware('throttle:forgotten_password');


     // Socialite Google login
    Route::get('google', 'App\Http\Controllers\GoogleAuthController@redirectToGoogle')->name('google.redirect');
    Route::get('google/callback', 'App\Http\Controllers\GoogleAuthController@handleGoogleCallback')->name('google.callback');


    // need to keep GET /logout for SAML SLO
    Route::get(
        'logout',
        [LoginController::class, 'logout']
    )->name('logout.get');

    Route::post(
        'logout',
        [LoginController::class, 'logout']
    )->name('logout.post');



    /**
     * Uploaded files API routes
     */

    // Get a file
    Route::get('{object_type}/{id}/files/{file_id}',
        [
            UploadedFilesController::class,
            'show'
        ]
    )->name('ui.files.show')
        ->where(['object_type' => 'assets|audits|maintenances|hardware|models|users|locations|accessories|consumables|licenses|suppliers|components']);

    // Upload files(s)
    Route::post('{object_type}/{id}/files',
        [
            UploadedFilesController::class,
            'store'
        ]
    )->name('ui.files.store')
        ->where(['object_type' => 'assets|audits|maintenances|hardware|models|users|locations|accessories|consumables|licenses|suppliers|components']);

    // Delete files(s)
    Route::delete('{object_type}/{id}/files/{file_id}/delete',
        [
            UploadedFilesController::class,
            'destroy'
        ]
    )->name('ui.files.destroy')
        ->where(['object_type' => 'assets|maintenances|hardware|models|users|locations|accessories|consumables|licenses|suppliers|components']);
});


/**
 * Health check route - skip middleware
 */
Route::withoutMiddleware(['web'])->get(
    '/health',
    [HealthController::class, 'get']
)->name('health');


Route::middleware(['auth'])->get(
    '/',
    [DashboardController::class, 'index']
)->name('home')
    ->breadcrumbs(fn (Trail $trail) =>
    $trail->push('Home', route('home'))
    );


Route::middleware(['auth'])->group(function () {
    Route::get('/bulkcheckoutlicense', function () {
        // Fetch licenses in category 63
        $licenses = App\Models\License::where('category_id', 63)->with('licenseseats')->get();
        return view('custom/bulk_checkout_license', compact('licenses'));
    })->name('custom.bulk_license.form');

    Route::post('/bulkcheckoutlicense', function (Illuminate\Http\Request $request) {
        $assignedTo = $request->input('assigned_to');
        $licenseIds = $request->input('license_ids', []);
        $notes = $request->input('notes', '');
        
        if (empty($assignedTo)) {
            return redirect()->back()->with('error', 'Karyawan harus dipilih!');
        }
        if (empty($licenseIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu kamera untuk di-checkout!');
        }

        $user = App\Models\User::find($assignedTo);
        if (!$user) {
            return redirect()->back()->with('error', 'Karyawan tidak ditemukan!');
        }

        $admin = auth()->user();
        $successCount = 0;
        $failedCount = 0;

        foreach ($licenseIds as $licenseId) {
            $license = App\Models\License::find($licenseId);
            if ($license) {
                $seat = App\Models\LicenseSeat::where('license_id', $license->id)->whereNull('assigned_to')->first();
                if ($seat) {
                    $seat->assigned_to = $user->id;
                    $seat->created_by = $admin->id;
                    $seat->save();

                    // Catat ke dalam audit logs Snipe-IT agar muncul di history user/lisensi
                    $seat->logCheckout($notes, $user);

                    // Trigger event untuk notifikasi Telegram
                    event(new App\Events\CheckoutableCheckedOut($seat, $user, $admin, $notes));
                    $successCount++;
                } else {
                    $failedCount++;
                }
            }
        }

        $msg = "Berhasil checkout {$successCount} lisensi kamera ke {$user->present()->fullName}.";
        if ($failedCount > 0) {
            $msg .= " Gagal checkout {$failedCount} lisensi karena seat penuh.";
        }

        return redirect()->back()->with('success', $msg);
    })->name('custom.bulk_license.process');

    Route::get('/bulkcheckinlicense', function () {
        // Fetch all active license seats that are checked out in category 63
        $seats = App\Models\LicenseSeat::whereNotNull('assigned_to')
            ->whereHas('license', function($q) {
                $q->where('category_id', 63);
            })->with(['license', 'user'])->get();
            
        return view('custom/bulk_checkin_license', compact('seats'));
    })->name('custom.bulk_license.checkin_form');

    Route::post('/bulkcheckinlicense', function (Illuminate\Http\Request $request) {
        $seatIds = $request->input('seat_ids', []);
        $notes = $request->input('notes', '');
        
        if (empty($seatIds)) {
            return redirect()->back()->with('error', 'Pilih minimal satu kamera untuk di-check-in!');
        }

        $admin = auth()->user();
        $successCount = 0;

        foreach ($seatIds as $seatId) {
            $seat = App\Models\LicenseSeat::find($seatId);
            if ($seat && $seat->assigned_to) {
                $user = $seat->user;

                // 1. Catat log checkin di database
                $seat->logCheckin($user, $notes);

                // 2. Kosongkan assigned_to
                $seat->assigned_to = null;
                $seat->save();

                // 3. Trigger event check-in untuk notifikasi Telegram
                event(new App\Events\CheckoutableCheckedIn($seat, $user, $admin, $notes));
                $successCount++;
            }
        }

        $msg = "Berhasil menarik (check-in) {$successCount} akses kamera.";
        return redirect()->back()->with('success', $msg);
    })->name('custom.bulk_license.checkin_process');
});



// Custom Track Cepat Feature
Route::get('/track-cepat', function () {
    return view('hardware.track_cepat');
})->middleware('auth')->name('custom.track_cepat');

Route::get('/track-cepat/search', function (Illuminate\Http\Request $request) {
    $prefix = DB::getTablePrefix();
    $queryStr = trim($request->input('query', $request->input('q', '')));
    $mode = trim($request->input('mode', 'all')); // 'all', 'asset', 'component'

    if (empty($queryStr)) {
        return response()->json(['error' => 'Harap masukkan Kode Barang / Tag Aset, Kode Komponen (COM-...), Serial Number, Kode BS, atau No. FAH!'], 400);
    }

    $isCompPrefixed = (bool)preg_match('/^COM[-\s]?\d+/i', $queryStr);

    // ==========================================
    // HELPER FUNCTION: SEARCH COMPONENT
    // ==========================================
    $searchComponentFn = function() use ($queryStr, $prefix) {
        // 1. Cari Komponen Aktif (non-deleted)
        $component = App\Models\Component::with(['category', 'company', 'location'])
            ->where(function($q) use ($queryStr) {
                $q->where('serial', $queryStr)
                  ->orWhere('name', $queryStr)
                  ->orWhere('serial', 'LIKE', "%{$queryStr}%")
                  ->orWhere('name', 'LIKE', "%{$queryStr}%")
                  ->orWhere('model_number', 'LIKE', "%{$queryStr}%")
                  ->orWhere('order_number', 'LIKE', "%{$queryStr}%")
                  ->orWhere('notes', 'LIKE', "%{$queryStr}%");
            })
            ->orderByRaw("CASE WHEN serial = ? THEN 0 WHEN name = ? THEN 1 ELSE 2 END", [$queryStr, $queryStr])
            ->orderBy('id', 'DESC')
            ->first();

        // 2. Fallback: Cari Komponen Terhapus / Diarsipkan (onlyTrashed)
        if (!$component) {
            $component = App\Models\Component::onlyTrashed()
                ->with(['category', 'company', 'location'])
                ->where(function($q) use ($queryStr) {
                    $q->where('serial', $queryStr)
                      ->orWhere('name', $queryStr)
                      ->orWhere('serial', 'LIKE', "%{$queryStr}%")
                      ->orWhere('name', 'LIKE', "%{$queryStr}%")
                      ->orWhere('model_number', 'LIKE', "%{$queryStr}%")
                      ->orWhere('order_number', 'LIKE', "%{$queryStr}%")
                      ->orWhere('notes', 'LIKE', "%{$queryStr}%");
                })
                ->orderByRaw("CASE WHEN serial = ? THEN 0 WHEN name = ? THEN 1 ELSE 2 END", [$queryStr, $queryStr])
                ->orderBy('id', 'DESC')
                ->first();
        }

        // 3. Fallback: Cari via Action Logs Komponen jika ada
        if (!$component) {
            $compLogId = DB::table('action_logs')
                ->where('item_type', 'App\\Models\\Component')
                ->where(function($q) use ($queryStr) {
                    $q->where('note', 'LIKE', "%{$queryStr}%")
                      ->orWhere('log_meta', 'LIKE', "%{$queryStr}%");
                })
                ->value('item_id');
            if ($compLogId) {
                $component = App\Models\Component::withTrashed()
                    ->with(['category', 'company', 'location'])
                    ->find($compLogId);
            }
        }

        if (!$component) return null;

        $isDeleted = $component->trashed();
        $deletedAt = $isDeleted ? ($component->deleted_at ? $component->deleted_at->format('Y-m-d H:i:s') : 'Ya') : null;

        $totalQty = (int)$component->qty;
        $assignedQty = (int)DB::table('components_assets')->where('component_id', $component->id)->sum('assigned_qty');
        $remainingQty = max(0, $totalQty - $assignedQty);
        $minAmt = (int)$component->min_amt;

        // Query unit aset yang pernah/sedang menggunakan komponen ini
        $assignedAssets = DB::table('components_assets')
            ->join('assets', 'components_assets.asset_id', '=', 'assets.id')
            ->leftJoin('models', 'assets.model_id', '=', 'models.id')
            ->leftJoin('categories', 'models.category_id', '=', 'categories.id')
            ->leftJoin('status_labels', 'assets.status_id', '=', 'status_labels.id')
            ->leftJoin('locations', 'assets.location_id', '=', 'locations.id')
            ->leftJoin('companies', 'assets.company_id', '=', 'companies.id')
            ->leftJoin('users', function($join) {
                $join->on('assets.assigned_to', '=', 'users.id')
                     ->where('assets.assigned_type', '=', 'App\\Models\\User');
            })
            ->where('components_assets.component_id', $component->id)
            ->select(
                'assets.id as asset_id',
                'assets.asset_tag',
                'assets.name as asset_name',
                'assets.deleted_at as asset_deleted_at',
                'models.name as model_name',
                'categories.name as category_name',
                'status_labels.name as status_name',
                'status_labels.color as status_color',
                'locations.name as location_name',
                'companies.name as company_name',
                'components_assets.assigned_qty',
                'components_assets.created_at as assigned_date',
                DB::raw("CONCAT(" . $prefix . "users.first_name, ' ', COALESCE(" . $prefix . "users.last_name, '')) as assigned_user")
            )
            ->orderBy('components_assets.id', 'DESC')
            ->get();

        $assignedList = [];
        foreach ($assignedAssets as $aa) {
            $isAssetTrashed = !empty($aa->asset_deleted_at);
            $assignedList[] = [
                'asset_id' => $aa->asset_id,
                'asset_tag' => $aa->asset_tag,
                'asset_name' => $aa->asset_name ?: ($aa->model_name ?: 'Aset Tanpa Nama'),
                'model_name' => $aa->model_name ?: '-',
                'category_name' => $aa->category_name ?: '-',
                'status_name' => $isAssetTrashed ? 'Arsip / Terhapus' : ($aa->status_name ?: 'Tanpa Status'),
                'status_color' => $isAssetTrashed ? '#d9534f' : ($aa->status_color ?: '#999'),
                'location_name' => $aa->location_name ?: '-',
                'company_name' => $aa->company_name ?: '-',
                'assigned_user' => !empty(trim($aa->assigned_user)) ? trim($aa->assigned_user) : '-',
                'assigned_qty' => (int)$aa->assigned_qty,
                'assigned_date' => $aa->assigned_date ? date('d-m-Y H:i', strtotime($aa->assigned_date)) : '-',
                'asset_url' => url('hardware/' . $aa->asset_id)
            ];
        }

        // Action Logs untuk Komponen
        $rawCompLogs = DB::table('action_logs')
            ->leftJoin('users as admin_user', 'action_logs.created_by', '=', 'admin_user.id')
            ->leftJoin('assets as target_asset', function($join) {
                $join->on('action_logs.target_id', '=', 'target_asset.id')
                     ->where('action_logs.target_type', '=', 'App\\Models\\Asset');
            })
            ->leftJoin('users as target_user', function($join) {
                $join->on('action_logs.target_id', '=', 'target_user.id')
                     ->where('action_logs.target_type', '=', 'App\\Models\\User');
            })
            ->leftJoin('locations as target_loc', function($join) {
                $join->on('action_logs.target_id', '=', 'target_loc.id')
                     ->where('action_logs.target_type', '=', 'App\\Models\\Location');
            })
            ->where('action_logs.item_type', 'App\\Models\\Component')
            ->where('action_logs.item_id', $component->id)
            ->select(
                'action_logs.id',
                'action_logs.action_type',
                'action_logs.action_date',
                'action_logs.note',
                'action_logs.log_meta',
                'action_logs.created_at',
                'action_logs.target_type',
                DB::raw("CONCAT(" . $prefix . "admin_user.first_name, ' ', COALESCE(" . $prefix . "admin_user.last_name, '')) as admin_name"),
                DB::raw("CASE 
                    WHEN " . $prefix . "action_logs.target_type = 'App\\\\Models\\\\Asset' THEN CONCAT(" . $prefix . "target_asset.name, ' (#', " . $prefix . "target_asset.asset_tag, ')')
                    WHEN " . $prefix . "action_logs.target_type = 'App\\\\Models\\\\User' THEN CONCAT(" . $prefix . "target_user.first_name, ' ', COALESCE(" . $prefix . "target_user.last_name, ''))
                    WHEN " . $prefix . "action_logs.target_type = 'App\\\\Models\\\\Location' THEN " . $prefix . "target_loc.name
                    ELSE '-'
                END as target_name")
            )
            ->orderBy('action_logs.id', 'DESC')
            ->take(50)
            ->get();

        $compLogs = [];
        foreach ($rawCompLogs as $cl) {
            $actType = strtolower($cl->action_type);
            $actionDesc = 'Aksi Komponen';
            if ($actType == 'checkout') {
                $actionDesc = 'Checkout (Dipasang pada ' . ($cl->target_name ?: 'Aset') . ')';
            } elseif ($actType == 'checkin from' || $actType == 'checkin') {
                $actionDesc = 'Checkin (Dilepas dari ' . ($cl->target_name ?: 'Aset') . ')';
            } elseif ($actType == 'create') {
                $actionDesc = 'Pembuatan Master Komponen';
            } elseif ($actType == 'update') {
                $actionDesc = 'Pembaruan Data Komponen';
            } else {
                $actionDesc = ucfirst($actType);
            }

            $compLogs[] = [
                'id' => $cl->id,
                'action' => $actType,
                'action_type' => $cl->action_type,
                'action_description' => $actionDesc,
                'created_at' => $cl->action_date ? date('Y-m-d H:i', strtotime($cl->action_date)) : date('Y-m-d H:i', strtotime($cl->created_at)),
                'admin_name' => !empty(trim($cl->admin_name)) ? trim($cl->admin_name) : 'Bakhtiyar Sierad',
                'target_name' => $cl->target_name ?: '-',
                'note' => !empty(trim($cl->note)) ? trim($cl->note) : '-'
            ];
        }

        $imageUrl = url('img/build/app/asset-placeholder.png');
        if (!empty($component->image)) {
            $imageUrl = url('uploads/components/' . $component->image);
        }

        return [
            'result_type' => 'component',
            'component' => [
                'id' => $component->id,
                'name' => $component->name,
                'serial' => $component->serial ?: '-',
                'category' => $component->category ? $component->category->name : '-',
                'model_number' => $component->model_number ?: '-',
                'order_number' => $component->order_number ?: '-',
                'purchase_date' => $component->purchase_date ? date('d-m-Y', strtotime($component->purchase_date)) : '-',
                'purchase_cost' => $component->purchase_cost ? 'Rp ' . number_format($component->purchase_cost, 0, ',', '.') : '-',
                'min_amt' => $minAmt,
                'total_qty' => $totalQty,
                'assigned_qty' => $assignedQty,
                'remaining_qty' => $remainingQty,
                'company' => $component->company ? $component->company->name : '-',
                'location' => $component->location ? $component->location->name : '-',
                'image_url' => $imageUrl,
                'component_url' => url('components/' . $component->id),
                'history_url' => url('components/' . $component->id . '#history'),
                'is_deleted' => $isDeleted,
                'deleted_at' => $deletedAt,
                'notes' => $component->notes ?: '-'
            ],
            'assigned_assets' => $assignedList,
            'logs' => $compLogs
        ];
    };

    // Jika mode eksklusif 'component' atau diawali prefix 'COM-', cari komponen terlebih dahulu
    if ($mode === 'component' || ($mode === 'all' && $isCompPrefixed)) {
        $compResult = $searchComponentFn();
        if ($compResult) {
            return response()->json($compResult);
        }
        if ($mode === 'component') {
            return response()->json(['error' => 'Komponen dengan Kode / Serial / Nama "' . htmlspecialchars($queryStr) . '" tidak ditemukan!'], 404);
        }
    }

    // ==========================================
    // PENCARIAN ASET IT (PC / LAPTOP / SERVER / DLL)
    // ==========================================
    $asset = null;
    if ($mode !== 'component') {
        // 1. Prioritaskan pencarian pada Aset AKTIF (non-deleted)
        $asset = App\Models\Asset::with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
            ->where(function($q) use ($queryStr) {
                $q->where('asset_tag', $queryStr)
                  ->orWhere('serial', $queryStr)
                  ->orWhere('asset_tag', 'LIKE', "%{$queryStr}%")
                  ->orWhere('serial', 'LIKE', "%{$queryStr}%")
                  ->orWhere('name', 'LIKE', "%{$queryStr}%")
                  ->orWhere('notes', 'LIKE', "%{$queryStr}%");
            })
            ->orderByRaw("CASE WHEN asset_tag = ? THEN 0 WHEN serial = ? THEN 1 ELSE 2 END", [$queryStr, $queryStr])
            ->orderBy('id', 'DESC')
            ->first();

        // 2. Pencarian relasi maintenance pada Aset Aktif
        if (!$asset) {
            $maintAssetIds = DB::table('maintenances')
                ->where('name', 'LIKE', "%{$queryStr}%")
                ->orWhere('notes', 'LIKE', "%{$queryStr}%")
                ->pluck('asset_id');

            if ($maintAssetIds->isNotEmpty()) {
                $asset = App\Models\Asset::with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                    ->whereIn('id', $maintAssetIds)
                    ->orderBy('id', 'DESC')
                    ->first();
            }
        }

        // 3. Pencarian relasi action_logs pada Aset Aktif
        if (!$asset) {
            $logAssetIds = DB::table('action_logs')
                ->where('item_type', 'App\\Models\\Asset')
                ->where('note', 'LIKE', "%{$queryStr}%")
                ->pluck('item_id');

            if ($logAssetIds->isNotEmpty()) {
                $asset = App\Models\Asset::with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                    ->whereIn('id', $logAssetIds)
                    ->orderBy('id', 'DESC')
                    ->first();
            }
        }

        // 4. Pencarian via Plugin Barang Rusak / BS (Reverse Lookup Kode BS)
        if (!$asset) {
            try {
                $scrapRowsRev = DB::select(
                    "SELECT kode_inv FROM bmkb_wp_2tqty.9VlGW_bm_hw_scrap 
                     WHERE kode = ? OR kode LIKE ? OR keterangan LIKE ? 
                     ORDER BY id DESC LIMIT 5", 
                    [$queryStr, "%{$queryStr}%", "%{$queryStr}%"]
                );
                if (!empty($scrapRowsRev)) {
                    $invTags = array_filter(array_column($scrapRowsRev, 'kode_inv'));
                    if (!empty($invTags)) {
                        $asset = App\Models\Asset::with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                            ->where(function($q) use ($invTags) {
                                $q->whereIn('asset_tag', $invTags)
                                  ->orWhereIn('serial', $invTags);
                            })
                            ->orderBy('id', 'DESC')
                            ->first();
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 5. Pencarian via Plugin Form Analisa Hardware (FAH)
        if (!$asset) {
            try {
                $fahRowsRev = DB::select(
                    "SELECT no_inventaris FROM bmkb_wp_2tqty.9VlGW_bm_hw_fah 
                     WHERE nomor = ? OR nomor LIKE ? OR no_inventaris LIKE ? 
                     ORDER BY id DESC LIMIT 5", 
                    [$queryStr, "%{$queryStr}%", "%{$queryStr}%"]
                );
                if (!empty($fahRowsRev)) {
                    $invTags = array_filter(array_column($fahRowsRev, 'no_inventaris'));
                    if (!empty($invTags)) {
                        $asset = App\Models\Asset::with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                            ->where(function($q) use ($invTags) {
                                $q->whereIn('asset_tag', $invTags)
                                  ->orWhereIn('serial', $invTags);
                            })
                            ->orderBy('id', 'DESC')
                            ->first();
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 6. Pencarian via Plugin Barang Keluar pada Aset Aktif
        if (!$asset) {
            try {
                $pluginRowsRev = DB::select("SELECT serial FROM bmkb_wp_2tqty.bm_inv_barang_keluar WHERE no_transaksi_sistem LIKE ? OR no_transaksi_manual LIKE ? OR serial LIKE ? ORDER BY id DESC LIMIT 5", ["%{$queryStr}%", "%{$queryStr}%", "%{$queryStr}%"]);
                if (!empty($pluginRowsRev)) {
                    $serials = array_filter(array_column($pluginRowsRev, 'serial'));
                    if (!empty($serials)) {
                        $asset = App\Models\Asset::with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                            ->whereIn('asset_tag', $serials)
                            ->orderBy('id', 'DESC')
                            ->first();
                    }
                }
            } catch (\Throwable $e) {}
        }

        // 7. FALLBACK: Jika tidak ditemukan di Aset Aktif sama sekali, baru cari di Aset Terhapus/Arsip (onlyTrashed)
        if (!$asset) {
            $asset = App\Models\Asset::onlyTrashed()
                ->with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                ->where(function($q) use ($queryStr) {
                    $q->where('asset_tag', $queryStr)
                      ->orWhere('serial', $queryStr)
                      ->orWhere('asset_tag', 'LIKE', "%{$queryStr}%")
                      ->orWhere('serial', 'LIKE', "%{$queryStr}%")
                      ->orWhere('name', 'LIKE', "%{$queryStr}%")
                      ->orWhere('notes', 'LIKE', "%{$queryStr}%");
                })
                ->orderByRaw("CASE WHEN asset_tag = ? THEN 0 WHEN serial = ? THEN 1 ELSE 2 END", [$queryStr, $queryStr])
                ->orderBy('id', 'DESC')
                ->first();

            // Fallback Trashed via Plugin BS
            if (!$asset) {
                try {
                    $scrapRowsRev = DB::select(
                        "SELECT kode_inv FROM bmkb_wp_2tqty.9VlGW_bm_hw_scrap 
                         WHERE kode = ? OR kode LIKE ? OR keterangan LIKE ? 
                         ORDER BY id DESC LIMIT 5", 
                        [$queryStr, "%{$queryStr}%", "%{$queryStr}%"]
                    );
                    if (!empty($scrapRowsRev)) {
                        $invTags = array_filter(array_column($scrapRowsRev, 'kode_inv'));
                        if (!empty($invTags)) {
                            $asset = App\Models\Asset::onlyTrashed()
                                ->with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                                ->where(function($q) use ($invTags) {
                                    $q->whereIn('asset_tag', $invTags)
                                      ->orWhereIn('serial', $invTags);
                                })
                                ->orderBy('id', 'DESC')
                                ->first();
                        }
                    }
                } catch (\Throwable $e) {}
            }

            // Fallback Trashed via Plugin FAH
            if (!$asset) {
                try {
                    $fahRowsRev = DB::select(
                        "SELECT no_inventaris FROM bmkb_wp_2tqty.9VlGW_bm_hw_fah 
                         WHERE nomor = ? OR nomor LIKE ? OR no_inventaris LIKE ? 
                         ORDER BY id DESC LIMIT 5", 
                        [$queryStr, "%{$queryStr}%", "%{$queryStr}%"]
                    );
                    if (!empty($fahRowsRev)) {
                        $invTags = array_filter(array_column($fahRowsRev, 'no_inventaris'));
                        if (!empty($invTags)) {
                            $asset = App\Models\Asset::onlyTrashed()
                                ->with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                                ->where(function($q) use ($invTags) {
                                    $q->whereIn('asset_tag', $invTags)
                                      ->orWhereIn('serial', $invTags);
                                })
                                ->orderBy('id', 'DESC')
                                ->first();
                        }
                    }
                } catch (\Throwable $e) {}
            }

            if (!$asset) {
                $maintAssetId = DB::table('maintenances')
                    ->where('name', 'LIKE', "%{$queryStr}%")
                    ->orWhere('notes', 'LIKE', "%{$queryStr}%")
                    ->value('asset_id');

                if ($maintAssetId) {
                    $asset = App\Models\Asset::withTrashed()
                        ->with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                        ->find($maintAssetId);
                }
            }

            if (!$asset) {
                $logAssetId = DB::table('action_logs')
                    ->where('item_type', 'App\\Models\\Asset')
                    ->where('note', 'LIKE', "%{$queryStr}%")
                    ->value('item_id');

                if ($logAssetId) {
                    $asset = App\Models\Asset::withTrashed()
                        ->with(['model', 'model.category', 'company', 'location', 'assignedTo', 'assetstatus'])
                        ->find($logAssetId);
                }
            }
        }
    }

    // Jika Aset tidak ditemukan dan mode adalah 'all', coba fallback cari ke Komponen
    if (!$asset && $mode === 'all') {
        $compResult = $searchComponentFn();
        if ($compResult) {
            return response()->json($compResult);
        }
    }

    if (!$asset) {
        return response()->json(['error' => 'Data Aset atau Komponen dengan kata kunci "' . htmlspecialchars($queryStr) . '" tidak ditemukan!'], 404);
    }

    $imageUrl = url('img/build/app/asset-placeholder.png');
    if (!empty($asset->image)) {
        $imageUrl = url('uploads/assets/' . $asset->image);
    } elseif ($asset->model && !empty($asset->model->image)) {
        $imageUrl = url('uploads/models/' . $asset->model->image);
    }

    $assigneeName = '-';
    $userUrl = null;
    if ($asset->assignedTo) {
        if ($asset->assigned_type == 'App\\Models\\User') {
            $assigneeName = trim($asset->assignedTo->first_name . ' ' . $asset->assignedTo->last_name);
            $userUrl = url('users/' . $asset->assigned_to);
        } else {
            $assigneeName = $asset->assignedTo->name;
        }
    }

    $isDeleted = $asset->trashed();
    $deletedAt = $isDeleted ? $asset->deleted_at->format('Y-m-d H:i:s') : null;

    // Ambil Komponen yang Terpasang pada Aset ini (components_assets)
    $installedComponents = DB::table('components_assets')
        ->join('components', 'components_assets.component_id', '=', 'components.id')
        ->leftJoin('categories', 'components.category_id', '=', 'categories.id')
        ->leftJoin('locations', 'components.location_id', '=', 'locations.id')
        ->where('components_assets.asset_id', $asset->id)
        ->whereNull('components.deleted_at')
        ->select(
            'components.id as component_id',
            'components.name as component_name',
            'components.serial as component_serial',
            'components.model_number',
            'categories.name as category_name',
            'locations.name as location_name',
            'components_assets.assigned_qty',
            'components_assets.created_at as installed_date'
        )
        ->orderBy('components_assets.id', 'DESC')
        ->get();

    $installedList = [];
    foreach ($installedComponents as $ic) {
        $installedList[] = [
            'component_id' => $ic->component_id,
            'component_name' => $ic->component_name,
            'component_serial' => $ic->component_serial ?: '-',
            'model_number' => $ic->model_number ?: '-',
            'category_name' => $ic->category_name ?: '-',
            'location_name' => $ic->location_name ?: '-',
            'assigned_qty' => (int)$ic->assigned_qty,
            'installed_date' => $ic->installed_date ? date('d-m-Y H:i', strtotime($ic->installed_date)) : '-',
            'component_url' => url('components/' . $ic->component_id)
        ];
    }

    $maintenances = DB::table('maintenances')
        ->leftJoin('suppliers', 'maintenances.supplier_id', '=', 'suppliers.id')
        ->leftJoin('users', 'maintenances.created_by', '=', 'users.id')
        ->where('maintenances.asset_id', $asset->id)
        ->select(
            'maintenances.id',
            'maintenances.name',
            'maintenances.asset_maintenance_type',
            'maintenances.start_date',
            'maintenances.completion_date',
            'maintenances.cost',
            'maintenances.notes',
            'suppliers.name as supplier_name',
            DB::raw("CONCAT(" . $prefix . "users.first_name, ' ', COALESCE(" . $prefix . "users.last_name, '')) as admin_name")
        )
        ->orderBy('maintenances.id', 'DESC')
        ->get();

    $rawLogs = DB::table('action_logs')
        ->leftJoin('users as admin_user', 'action_logs.created_by', '=', 'admin_user.id')
        ->leftJoin('users as target_user', function($join) {
            $join->on('action_logs.target_id', '=', 'target_user.id')
                 ->where('action_logs.target_type', '=', 'App\\Models\\User');
        })
        ->leftJoin('locations as target_loc', function($join) {
            $join->on('action_logs.target_id', '=', 'target_loc.id')
                 ->where('action_logs.target_type', '=', 'App\\Models\\Location');
        })
        ->leftJoin('assets as target_asset', function($join) {
            $join->on('action_logs.target_id', '=', 'target_asset.id')
                 ->where('action_logs.target_type', '=', 'App\\Models\\Asset');
        })
        ->where('action_logs.item_type', 'App\\Models\\Asset')
        ->where('action_logs.item_id', $asset->id)
        ->select(
            'action_logs.id',
            'action_logs.action_type',
            'action_logs.action_date',
            'action_logs.note',
            'action_logs.log_meta',
            'action_logs.created_at',
            'action_logs.target_type',
            DB::raw("CONCAT(" . $prefix . "admin_user.first_name, ' ', COALESCE(" . $prefix . "admin_user.last_name, '')) as admin_name"),
            DB::raw("CASE 
                WHEN " . $prefix . "action_logs.target_type = 'App\\\\Models\\\\User' THEN CONCAT(" . $prefix . "target_user.first_name, ' ', COALESCE(" . $prefix . "target_user.last_name, ''))
                WHEN " . $prefix . "action_logs.target_type = 'App\\\\Models\\\\Location' THEN " . $prefix . "target_loc.name
                WHEN " . $prefix . "action_logs.target_type = 'App\\\\Models\\\\Asset' THEN CONCAT(" . $prefix . "target_asset.name, ' (#', " . $prefix . "target_asset.asset_tag, ')')
                ELSE '-'
            END as target_name")
        )
        ->orderBy('action_logs.id', 'DESC')
        ->take(50)
        ->get();

    $barangKeluarList = [];
    try {
        $searchTerms = [$asset->asset_tag];
        if (!empty($asset->serial) && $asset->serial !== '-') {
            $searchTerms[] = $asset->serial;
        }

        $pluginRows = DB::select(
            "SELECT * FROM bmkb_wp_2tqty.bm_inv_barang_keluar 
             WHERE serial = ? OR serial LIKE ? OR serial = ? 
             ORDER BY id DESC", 
            [$asset->asset_tag, '%' . $asset->asset_tag . '%', $asset->serial ?: $asset->asset_tag]
        );

        foreach ($pluginRows as $pr) {
            $noSjVal = !empty($pr->no_transaksi_sistem) ? $pr->no_transaksi_sistem : ($pr->no_transaksi_manual ?: '-');
            
            $tujuanParts = [];
            if (!empty($pr->untuk_user)) $tujuanParts[] = $pr->untuk_user;
            
            $extraTujuan = [];
            if (!empty($pr->untuk_cabang)) $extraTujuan[] = $pr->untuk_cabang;
            if (!empty($pr->ke_bagian)) $extraTujuan[] = $pr->ke_bagian;
            if (!empty($extraTujuan)) $tujuanParts[] = '(' . implode(' / ', $extraTujuan) . ')';
            
            $tujuanStr = !empty($tujuanParts) ? implode(' ', $tujuanParts) : '-';

            $barangKeluarList[] = [
                'id' => $pr->id,
                'kode_barang' => !empty($pr->serial) ? $pr->serial : $asset->asset_tag,
                'nama_barang' => !empty($pr->nama_barang) ? $pr->nama_barang : $asset->name,
                'no_sj' => $noSjVal,
                'tujuan' => $tujuanStr,
                'dibuat_tanggal' => $pr->tanggal_keluar ? date('d-m-Y', strtotime($pr->tanggal_keluar)) : date('d-m-Y', strtotime($pr->created_at)),
                'notes' => $pr->keterangan ?? '-'
            ];
        }
    } catch (\Throwable $e) {}

    $bsRecords = [];
    $bsMap = [];

    // 1. Direct Table Lookup dari Database Plugin Barang Rusak / Scrap (9VlGW_bm_hw_scrap)
    try {
        $scrapDbRows = DB::select(
            "SELECT * FROM bmkb_wp_2tqty.9VlGW_bm_hw_scrap 
             WHERE kode_inv = ? OR kode_inv = ? OR kode_inv LIKE ? 
             ORDER BY id DESC", 
            [$asset->asset_tag, $asset->serial ?: $asset->asset_tag, '%' . $asset->asset_tag . '%']
        );
        foreach ($scrapDbRows as $sdb) {
            $bCode = strtoupper(trim($sdb->kode));
            if (!empty($bCode) && !isset($bsMap[$bCode])) {
                $bDate = $sdb->tanggal_cek ?: ($sdb->tanggal_input ? date('Y-m-d', strtotime($sdb->tanggal_input)) : date('Y-m-d', strtotime($sdb->created_at)));
                $bsMap[$bCode] = [
                    'bs_code' => $bCode,
                    'nama_barang' => $sdb->nama_barang ?: ($asset->name ?: '-'),
                    'bs_date' => $bDate,
                    'notes' => $sdb->keterangan ?: "Dokumen Berita Acara {$bCode} terkait aset ini.",
                    'user_input' => $sdb->user_input ?: '-',
                    'status' => $sdb->status ?: 'Tercatat',
                    'dus_no' => $sdb->dus_no ?: '-',
                    'gambar_1' => !empty($sdb->gambar_1) ? $sdb->gambar_1 : null,
                    'gambar_2' => !empty($sdb->gambar_2) ? $sdb->gambar_2 : null
                ];
            }
        }
    } catch (\Throwable $e) {}

    // 2. Fallback: Ekstraksi Kode BS dari Notes, Maintenance, Action Logs
    $extractBsFromText = function($text, $defaultDate, $defaultNote) use (&$bsMap, $asset) {
        if (empty($text)) return;
        if (preg_match_all('/BS[-\s]?\d+/i', $text, $matches)) {
            foreach ($matches[0] as $codeRaw) {
                $code = strtoupper(trim($codeRaw));
                if (!isset($bsMap[$code])) {
                    $bsMap[$code] = [
                        'bs_code' => $code,
                        'nama_barang' => $asset->name ?: '-',
                        'bs_date' => $defaultDate,
                        'notes' => !empty($defaultNote) ? $defaultNote : "Dokumen Berita Acara {$code} terkait aset ini.",
                        'user_input' => '-',
                        'status' => 'Tercatat di Riwayat Snipe-IT',
                        'dus_no' => '-',
                        'gambar_1' => null,
                        'gambar_2' => null
                    ];
                }
            }
        }
    };

    $extractBsFromText($asset->notes, $asset->updated_at ? $asset->updated_at->format('Y-m-d') : $asset->created_at->format('Y-m-d'), $asset->notes);

    foreach ($maintenances as $m) {
        $mNote = trim(($m->name ?? '') . ' | ' . ($m->notes ?? ''));
        $extractBsFromText($mNote, $m->start_date ?: date('Y-m-d'), $mNote);
    }

    foreach ($rawLogs as $l) {
        $lDate = $l->action_date ? date('Y-m-d', strtotime($l->action_date)) : date('Y-m-d', strtotime($l->created_at));
        $extractBsFromText($l->note, $lDate, $l->note);
    }

    $bsRecords = array_values($bsMap);

    // 3. Direct Table Lookup dari Database Plugin FAH (9VlGW_bm_hw_fah)
    $fahDbRow = null;
    try {
        $fahRows = DB::select(
            "SELECT * FROM bmkb_wp_2tqty.9VlGW_bm_hw_fah 
             WHERE no_inventaris = ? OR no_inventaris = ? OR no_inventaris LIKE ? 
             ORDER BY id DESC LIMIT 1",
            [$asset->asset_tag, $asset->serial ?: $asset->asset_tag, '%' . $asset->asset_tag . '%']
        );
        if (!empty($fahRows)) {
            $fahDbRow = $fahRows[0];
        }
    } catch (\Throwable $e) {}

    $fahNumber = '-';
    $fahDate = '-';
    $fahDasar = '-';
    $fahIndikasi = '-';
    $fahTindakan = '-';
    $fahHasil = '-';
    $fahGambar1 = null;
    $fahGambar2 = null;
    $fahUserPic = '-';
    $fahCabang = '-';

    if ($fahDbRow) {
        $fahNumber = $fahDbRow->nomor ?: '-';
        $fahDate = $fahDbRow->tanggal_pemeriksaan ?: ($fahDbRow->created_at ? date('Y-m-d', strtotime($fahDbRow->created_at)) : '-');
        $fahDasar = $fahDbRow->dasar_analisa ?: '-';
        $fahIndikasi = $fahDbRow->indikasi_kerusakan ?: '-';
        $fahTindakan = $fahDbRow->tindakan_pemeriksaan ?: '-';
        $fahHasil = $fahDbRow->hasil_pemeriksaan ?: '-';
        $fahGambar1 = !empty($fahDbRow->gambar_1) ? $fahDbRow->gambar_1 : null;
        $fahGambar2 = !empty($fahDbRow->gambar_2) ? $fahDbRow->gambar_2 : null;
        $fahUserPic = $fahDbRow->nama_user_pic ?: '-';
        $fahCabang = $fahDbRow->cabang_bagian ?: '-';
    } else {
        $combinedText = ($asset->name ?? '') . ' ' . ($asset->notes ?? '') . ' ' . ($asset->asset_tag ?? '');
        if (preg_match('/No\.?\s*FAH[:\s]*([^\s|]+)/i', $combinedText, $fMatch)) {
            $fahNumber = trim($fMatch[1]);
            $fahDate = $asset->updated_at ? $asset->updated_at->format('Y-m-d') : $asset->created_at->format('Y-m-d');
        }

        foreach ($maintenances as $m) {
            $mText = ($m->name ?? '') . ' ' . ($m->notes ?? '');
            if ($fahNumber === '-' && preg_match('/No\.?\s*FAH[:\s]*([^\s|]+)/i', $mText, $fMatch2)) {
                $fahNumber = trim($fMatch2[1]);
                $fahDate = $m->start_date ?: $fahDate;
            }
        }
    }

    $fahSpecs = [
        'processor' => $asset->_snipeit_jenis_processor_12 ?: '-',
        'ram_jenis' => $asset->_snipeit_jenis_ram_5 ?: '-',
        'ram_kapasitas' => $asset->_snipeit_kapasitas_ram_4 ?: '-',
        'disk_jenis' => $asset->_snipeit_jenis_disk_10 ?: '-',
        'disk_kapasitas' => $asset->_snipeit_kapasitas_disk_9 ?: '-',
        'disk2_jenis' => $asset->_snipeit_jenis_disk_2_13 ?: '-',
        'disk2_kapasitas' => $asset->_snipeit_kapasitas_disk_2_14 ?: '-',
        'os' => $asset->_snipeit_operating_system_3 ?: '-',
        'ip_address' => $asset->_snipeit_ip_address_2 ?: '-',
        'mac_address' => $asset->_snipeit_mac_address_1 ?: '-',
        'antivirus_mcafee' => $asset->_snipeit_anti_virus_mcafee_15 ?: '-',
        'core_vcpu' => $asset->_snipeit_core_vcpu_20 ?: '-',
        'fah_number' => $fahNumber,
        'fah_date' => $fahDate !== '-' ? $fahDate : ($asset->updated_at ? $asset->updated_at->format('Y-m-d') : '-'),
        'dasar_analisa' => $fahDasar,
        'indikasi_kerusakan' => $fahIndikasi,
        'tindakan_pemeriksaan' => $fahTindakan,
        'hasil_pemeriksaan' => $fahHasil,
        'gambar_1' => $fahGambar1,
        'gambar_2' => $fahGambar2,
        'nama_user_pic' => $fahUserPic,
        'cabang_bagian' => $fahCabang,
        'fah_url' => url('analisa/cpu-intel-noncore')
    ];

    $logs = [];
    foreach ($rawLogs as $l) {
        $changedLines = [];
        if (!empty($l->log_meta)) {
            $metaData = json_decode($l->log_meta, true);
            if (is_array($metaData)) {
                foreach ($metaData as $fieldKey => $changeVal) {
                    if (is_array($changeVal) && (isset($changeVal['old']) || isset($changeVal['new']))) {
                        $oldStr = isset($changeVal['old']) ? (is_null($changeVal['old']) ? 'null' : (string)$changeVal['old']) : 'null';
                        $newStr = isset($changeVal['new']) ? (is_null($changeVal['new']) ? 'null' : (string)$changeVal['new']) : 'null';
                        $fieldLabel = ucwords(str_replace(['_', 'id'], [' ', ''], $fieldKey));
                        $changedLines[] = "{$fieldLabel}: [{$oldStr}] &rarr; {$newStr}";
                    }
                }
            }
        }

        $changedDiffStr = !empty($changedLines) ? implode('<br>', $changedLines) : '-';
        $actDateFormatted = $l->action_date ? date('Y-m-d H:i', strtotime($l->action_date)) : date('Y-m-d H:i', strtotime($l->created_at));
        $adminUserStr = !empty(trim($l->admin_name)) ? trim($l->admin_name) : 'Bakhtiyar Sierad';
        $targetUserStr = !empty(trim($l->target_name)) ? trim($l->target_name) : '-';
        $noteTextStr = !empty(trim($l->note)) ? trim($l->note) : '-';

        $actType = strtolower($l->action_type);
        $actionDesc = 'Aksi Sistem';
        if ($actType == 'checkout') {
            $actionDesc = 'Checkout (Dipinjamkan' . ($targetUserStr !== '-' ? ' ke ' . $targetUserStr : '') . ')';
        } elseif ($actType == 'checkin from') {
            $actionDesc = 'Checkin (Pengembalian' . ($targetUserStr !== '-' ? ' dari ' . $targetUserStr : '') . ')';
        } elseif ($actType == 'statusupdate') {
            $actionDesc = 'Pembaruan Status Aset';
        } elseif ($actType == 'update') {
            $actionDesc = 'Pembaruan Data & Atribut Aset';
        } elseif ($actType == 'delete') {
            $actionDesc = 'Penghapusan / Arsip Aset';
        } elseif ($actType == 'create') {
            $actionDesc = 'Pembuatan Record Aset Baru';
        } elseif ($actType == 'audit') {
            $actionDesc = 'Audit Fisik Aset';
        } else {
            $actionDesc = ucfirst($actType);
        }

        $logs[] = [
            'id' => $l->id,
            'action_type' => $l->action_type,
            'action' => strtolower($l->action_type),
            'action_description' => $actionDesc,
            'action_date' => $actDateFormatted,
            'created_at' => $actDateFormatted,
            'admin_name' => $adminUserStr,
            'created_by' => $adminUserStr,
            'target_name' => $targetUserStr,
            'target' => $targetUserStr,
            'note' => $noteTextStr,
            'notes' => $noteTextStr,
            'item' => ($asset->name ?? 'Asset') . ' #' . $asset->asset_tag,
            'changed' => $changedDiffStr
        ];
    }

    $lastActionDate = $asset->updated_at ? $asset->updated_at->format('Y-m-d H:i') : '-';
    $lastActionType = 'update';

    if (count($logs) > 0) {
        $lastLog = $logs[0];
        $lastActionDate = $lastLog['created_at'];
        $lastActionType = $lastLog['action'];
    }

    $firstBsCode = count($bsRecords) > 0 ? $bsRecords[0]['bs_code'] : '-';
    $firstBsDate = count($bsRecords) > 0 ? $bsRecords[0]['bs_date'] : '-';

    return response()->json([
        'result_type' => 'asset',
        'asset' => [
            'id' => $asset->id,
            'name' => $asset->name ?: ($asset->model ? $asset->model->name : 'Aset Tanpa Nama'),
            'asset_tag' => $asset->asset_tag,
            'serial' => $asset->serial ?: '-',
            'category' => ($asset->model && $asset->model->category) ? $asset->model->category->name : '-',
            'model' => $asset->model ? $asset->model->name : '-',
            'company' => $asset->company ? $asset->company->name : '-',
            'location' => $asset->location ? $asset->location->name : '-',
            'status_id' => $asset->status_id,
            'status_name' => $asset->assetstatus ? $asset->assetstatus->name : 'Tanpa Status',
            'status_color' => $asset->assetstatus ? $asset->assetstatus->color : '#999',
            'assignee' => $assigneeName,
            'user_url' => $userUrl,
            'asset_url' => url('hardware/' . $asset->id),
            'history_url' => url('hardware/' . $asset->id . '#history'),
            'image_url' => $imageUrl,
            'is_deleted' => $isDeleted,
            'deleted_at' => $deletedAt,
            'has_trashed_history' => (!$isDeleted && App\Models\Asset::onlyTrashed()->where('asset_tag', $asset->asset_tag)->where('id', '!=', $asset->id)->exists()),
            'notes' => $asset->notes ?: '-',
            'bs_code' => $firstBsCode,
            'bs_date' => $firstBsDate,
            'bs_records' => $bsRecords,
            'last_action_date' => $lastActionDate,
            'last_action_type' => $lastActionType
        ],
        'installed_components' => $installedList,
        'fah_specs' => $fahSpecs,
        'barang_keluar' => $barangKeluarList,
        'maintenances' => $maintenances,
        'logs' => $logs
    ]);
})->name('custom.track_cepat.search');


// Custom Analisa Hardware Routes
Route::middleware(['auth'])->group(function () {
    Route::get('analisa/cpu-intel-noncore', [\App\Http\Controllers\HardwareAnalisaController::class, 'intelNonCore'])->name('hardware.analisa.cpu_intel_noncore');
    Route::post('analisa/toggle-upgrade-status', [\App\Http\Controllers\HardwareAnalisaController::class, 'toggleUpgradeStatus'])->name('hardware.analisa.toggle_upgrade');
    Route::get('analisa/progress-report', [\App\Http\Controllers\HardwareAnalisaController::class, 'progressReport'])->name('hardware.analisa.progress_report');
    Route::post('analisa/create-snapshot', [\App\Http\Controllers\HardwareAnalisaController::class, 'createSnapshot'])->name('hardware.analisa.create_snapshot');
    Route::post('analisa/delete-snapshot', [\App\Http\Controllers\HardwareAnalisaController::class, 'deleteSnapshot'])->name('hardware.analisa.delete_snapshot');
    Route::get('analisa/print-report', [\App\Http\Controllers\HardwareAnalisaController::class, 'printReport'])->name('hardware.analisa.print_report');
    Route::get('analisa/components-list', [\App\Http\Controllers\HardwareAnalisaController::class, 'getComponentsList'])->name('hardware.analisa.components_list');
    Route::post('analisa/complete-upgrade', [\App\Http\Controllers\HardwareAnalisaController::class, 'completeUpgrade'])->name('hardware.analisa.complete_upgrade');

    // FAB Quick Lookup & Check-in Repair / Relocation
    Route::get('/custom/lookup-asset', function(Illuminate\Http\Request $request) {
        $q = trim($request->input('query', ''));
        $tag = trim($request->input('tag', ''));
        $searchTerm = $q ?: $tag;
        if (empty($searchTerm)) return response()->json($q ? [] : ['error' => 'Not found'], $q ? 200 : 404);

        if ($tag) {
            $a = App\Models\Asset::with(['model', 'assignedTo', 'assetstatus', 'location', 'defaultLoc'])
                ->where('asset_tag', $tag)
                ->orWhere('serial', $tag)
                ->first();
            if (!$a) return response()->json(['error' => 'Aset tidak ditemukan'], 404);

            $img = url('img/build/app/asset-placeholder.png');
            if ($a->image) $img = url('uploads/assets/' . $a->image);
            elseif ($a->model && $a->model->image) $img = url('uploads/models/' . $a->model->image);

            $locName = $a->location ? $a->location->name : ($a->defaultLoc ? $a->defaultLoc->name : '-');
            $assigneeName = '-';
            if ($a->assignedTo) {
                if ($a->assigned_type == 'App\\Models\\User') {
                    $assigneeName = trim($a->assignedTo->first_name . ' ' . $a->assignedTo->last_name) . ' (User)';
                } elseif ($a->assigned_type == 'App\\Models\\Location') {
                    $assigneeName = $a->assignedTo->name . ' (Location)';
                } else {
                    $assigneeName = $a->assignedTo->name;
                }
            }

            return response()->json([
                'id' => $a->id,
                'name' => $a->name ?: ($a->model ? $a->model->name : 'Asset'),
                'asset_tag' => $a->asset_tag,
                'serial' => $a->serial ?: '-',
                'status' => $a->assetstatus ? $a->assetstatus->name : 'Tanpa Status',
                'location' => $locName,
                'location_id' => $a->location_id ?: $a->rtd_location_id,
                'assignee' => $assigneeName,
                'assigned_to_id' => $a->assigned_to,
                'assigned_type' => $a->assigned_type,
                'image_url' => $img
            ]);
        }

        $assets = App\Models\Asset::with(['model', 'assignedTo', 'assetstatus', 'location', 'defaultLoc'])
            ->where('asset_tag', 'LIKE', "%{$searchTerm}%")
            ->orWhere('serial', 'LIKE', "%{$searchTerm}%")
            ->orWhere('name', 'LIKE', "%{$searchTerm}%")
            ->take(10)
            ->get();
        $results = [];
        foreach ($assets as $a) {
            $img = url('img/build/app/asset-placeholder.png');
            if ($a->image) $img = url('uploads/assets/' . $a->image);
            elseif ($a->model && $a->model->image) $img = url('uploads/models/' . $a->model->image);

            $locName = $a->location ? $a->location->name : ($a->defaultLoc ? $a->defaultLoc->name : '-');
            $assigneeName = '-';
            if ($a->assignedTo) {
                if ($a->assigned_type == 'App\\Models\\User') {
                    $assigneeName = trim($a->assignedTo->first_name . ' ' . $a->assignedTo->last_name);
                } else {
                    $assigneeName = $a->assignedTo->name;
                }
            }

            $results[] = [
                'id' => $a->id,
                'name' => $a->name ?: ($a->model ? $a->model->name : 'Asset'),
                'asset_tag' => $a->asset_tag,
                'serial' => $a->serial ?: '-',
                'status' => $a->assetstatus ? $a->assetstatus->name : 'Tanpa Status',
                'company' => $a->company ? $a->company->name : '-',
                'company_id' => $a->company_id,
                'location' => $locName,
                'location_id' => $a->location_id ?: $a->rtd_location_id,
                'assignee' => $assigneeName,
                'image_url' => $img
            ];
        }
        return response()->json($results);
    })->name('custom.lookup_asset');

    Route::post('/custom/checkin-to-repair', function(Illuminate\Http\Request $request) {
        $tag = trim($request->input('asset_tag', ''));
        $notes = trim($request->input('notes', ''));
        $statusId = $request->input('status_id', 7); // Default 7 = Asset Dalam Perbaikan
        $asset = App\Models\Asset::where('asset_tag', $tag)->orWhere('serial', $tag)->first();
        if (!$asset) {
            return response()->json(['error' => 'Aset dengan tag ' . $tag . ' tidak ditemukan!'], 404);
        }
        $adminUser = auth()->user() ?: \App\Models\User::find(2);
        $oldTarget = $asset->assignedTo;
        $wasCheckedOut = $oldTarget ? true : false;
        
        if ($oldTarget) {
            $originalValues = $asset->getRawOriginal();
            $checkin_at = date('Y-m-d H:i:s');
            $asset->expected_checkin = null;
            $asset->assignedTo()->disassociate($asset);
            $asset->accepted = null;
            $asset->last_checkin = $checkin_at;
            $asset->status_id = $statusId;
            $asset->save();
            event(new \App\Events\CheckoutableCheckedIn($asset, $oldTarget, $adminUser, $notes ?: 'Ditarik ke perbaikan', $checkin_at, $originalValues));
        } else {
            $asset->status_id = $statusId;
            $asset->save();
        }

        // Pastikan catatan kerusakan selalu masuk ke kolom Notes di History aset
        if (!empty($notes)) {
            $latestLog = \App\Models\Actionlog::where('item_type', \App\Models\Asset::class)
                ->where('item_id', $asset->id)
                ->latest('id')
                ->first();
            if ($latestLog) {
                $latestLog->note = $notes;
                $latestLog->save();
            }
        }

        return response()->json([
            'success' => 'Berhasil ditarik ke status perbaikan dengan catatan kerusakan tersimpan.',
            'asset_name' => $asset->name,
            'asset_tag' => $asset->asset_tag,
            'was_checked_out' => $wasCheckedOut
        ]);
    })->name('custom.checkin_to_repair.process');

    // Route: Update Lokasi / Relokasi Checkout Cepat
    Route::post('/custom/relocate-checkout', function(Illuminate\Http\Request $request) {
        $tag = trim($request->input('asset_tag', ''));
        $targetType = $request->input('target_type', 'location'); // 'location' or 'user'
        $targetId = (int)$request->input('target_id', 0);
        $customCompanyId = (int)$request->input('custom_company_id', 0);
        $customLocationId = (int)$request->input('custom_location_id', 0);
        $syncUserProfile = (bool)$request->input('sync_user_profile', false);
        $statusId = (int)$request->input('status_id', 4); // 4 = Asset Terpasang
        $notes = trim($request->input('notes', ''));

        if (empty($tag)) {
            return response()->json(['error' => 'Harap masukkan atau scan Tag Aset!'], 422);
        }
        if (!$targetId) {
            return response()->json(['error' => 'Harap pilih target Lokasi atau Karyawan baru!'], 422);
        }

        $asset = App\Models\Asset::where('asset_tag', $tag)->orWhere('serial', $tag)->first();
        if (!$asset) {
            return response()->json(['error' => 'Aset dengan tag ' . $tag . ' tidak ditemukan!'], 404);
        }

        $adminUser = auth()->user() ?: \App\Models\User::find(2); // Default Bakhtiyar Sierad if not auth
        $wasInStock = (!$asset->assigned_to || $asset->status_id == 2);
        $oldTarget = $asset->assignedTo;

        // STEP 1: Jika aset sedang dipegang target sebelumnya, lakukan auto-checkin resmi terlebih dahulu
        if ($oldTarget) {
            $originalValues = $asset->getRawOriginal();
            $checkin_at = date('Y-m-d H:i:s');
            $checkinNote = 'Auto-checkin sebelum relokasi: ' . ($notes ?: 'Perubahan penempatan lokasi/user');
            $asset->expected_checkin = null;
            $asset->assignedTo()->disassociate($asset);
            $asset->accepted = null;
            $asset->last_checkin = $checkin_at;
            $asset->save();
            event(new \App\Events\CheckoutableCheckedIn($asset, $oldTarget, $adminUser, $checkinNote, $checkin_at, $originalValues));
        }

        // STEP 2: Tentukan Target Model Baru (Location atau User) & Sinkronisasi Lokasi/PT
        $targetModel = null;
        $targetDisplayName = '';
        $finalLocationId = null;
        $finalCompanyId = null;
        $userProfileUpdated = false;

        if ($targetType === 'location') {
            $targetModel = \App\Models\Location::find($targetId);
            if (!$targetModel) {
                return response()->json(['error' => 'Lokasi dengan ID ' . $targetId . ' tidak ditemukan!'], 404);
            }
            $targetDisplayName = $targetModel->name;
            $finalLocationId = $targetId;
            $finalCompanyId = $customCompanyId ?: ($targetModel->company_id ?: null);
        } else {
            $targetModel = \App\Models\User::find($targetId);
            if (!$targetModel) {
                return response()->json(['error' => 'User dengan ID ' . $targetId . ' tidak ditemukan!'], 404);
            }
            $targetDisplayName = trim($targetModel->first_name . ' ' . $targetModel->last_name);
            $finalLocationId = $customLocationId ?: ($targetModel->location_id ?: $asset->location_id);
            $finalCompanyId = $customCompanyId ?: ($targetModel->company_id ?: null);

            // Jika admin memilih opsi perbarui profil karyawan
            if ($syncUserProfile && $targetModel) {
                $userChanged = false;
                if ($customCompanyId && $targetModel->company_id != $customCompanyId) {
                    $targetModel->company_id = $customCompanyId;
                    $userChanged = true;
                }
                if ($customLocationId && $targetModel->location_id != $customLocationId) {
                    $targetModel->location_id = $customLocationId;
                    $userChanged = true;
                }
                if ($userChanged) {
                    $targetModel->save();
                    $userProfileUpdated = true;
                }
            }
        }

        // Susun Catatan Checkout
        if (!empty($notes)) {
            $checkoutNote = $notes;
        } elseif ($wasInStock) {
            $checkoutNote = 'Penyerahan & checkout aset dari Stock ke ' . $targetDisplayName;
        } else {
            $checkoutNote = 'Relokasi penempatan aset ke ' . $targetDisplayName;
        }
        
        // STEP 3: Eksekusi checkout standar Snipe-IT (Langsung checkout jika dari Stock, atau checkout baru setelah checkin)
        $asset->checkOut($targetModel, $adminUser, now(), null, $checkoutNote, $asset->name);

        // Update status & sinkronisasi lokasi fisik serta default RTD location dan Company
        $asset->status_id = $statusId;
        if ($finalLocationId) {
            $asset->location_id = $finalLocationId;
            $asset->rtd_location_id = $finalLocationId;
        }
        if ($finalCompanyId) {
            $asset->company_id = $finalCompanyId;
        }
        $asset->save();

        // Pastikan catatan tersimpan ke Actionlog terbaru
        $latestLog = \App\Models\Actionlog::where('item_type', \App\Models\Asset::class)
            ->where('item_id', $asset->id)
            ->latest('id')
            ->first();
        if ($latestLog) {
            $latestLog->note = $checkoutNote;
            $latestLog->save();
        }

        $successMessage = $wasInStock 
            ? ('Aset (dari Stock) berhasil di-checkout ke: ' . $targetDisplayName)
            : ('Aset berhasil direlokasi & checkout ke: ' . $targetDisplayName);

        $locObj = $finalLocationId ? \App\Models\Location::find($finalLocationId) : null;
        $compObj = $asset->company_id ? \App\Models\Company::find($asset->company_id) : null;

        return response()->json([
            'success' => $successMessage,
            'asset_name' => $asset->name,
            'asset_tag' => $asset->asset_tag,
            'was_in_stock' => $wasInStock,
            'target_name' => $targetDisplayName,
            'target_type' => $targetType,
            'location_name' => $locObj ? $locObj->name : '-',
            'company_name' => $compObj ? $compObj->name : '-',
            'user_profile_updated' => $userProfileUpdated
        ]);
    })->name('custom.relocate_checkout.process');

    // Modul Pinjam Cepat / Peminjaman Aset IT (Status 14: Asset Dipinjamkan)
    Route::post('/custom/loan-checkout', function(Illuminate\Http\Request $request) {
        $tag = trim($request->input('asset_tag'));
        $targetType = $request->input('target_type', 'user');
        $targetId = $request->input('target_id');
        $customCompanyId = $request->input('custom_company_id');
        $customLocationId = $request->input('custom_location_id');
        $syncUserProfile = (bool)$request->input('sync_user_profile', false);
        $expectedCheckin = $request->input('expected_checkin');
        $notes = trim($request->input('notes'));

        if (empty($tag)) {
            return response()->json(['error' => 'Tag Aset atau Serial Number tidak boleh kosong!'], 422);
        }

        if (empty($targetId)) {
            return response()->json(['error' => 'Target Peminjam (Karyawan atau Lokasi) wajib dipilih!'], 422);
        }

        $asset = App\Models\Asset::where('asset_tag', $tag)->orWhere('serial', $tag)->first();
        if (!$asset) {
            return response()->json(['error' => 'Aset dengan tag ' . $tag . ' tidak ditemukan!'], 404);
        }

        $adminUser = auth()->user() ?: \App\Models\User::find(2); // Default Bakhtiyar Sierad if not auth
        $wasInStock = (!$asset->assigned_to || $asset->status_id == 2);
        $oldTarget = $asset->assignedTo;

        // STEP 1: Jika aset sedang dipegang target sebelumnya, lakukan auto-checkin resmi terlebih dahulu
        if ($oldTarget) {
            $originalValues = $asset->getRawOriginal();
            $checkin_at = date('Y-m-d H:i:s');
            $checkinNote = 'Auto-checkin sebelum dipinjamkan: ' . ($notes ?: 'Peminjaman Aset Baru');
            $asset->expected_checkin = null;
            $asset->assignedTo()->disassociate($asset);
            $asset->accepted = null;
            $asset->last_checkin = $checkin_at;
            $asset->save();
            event(new \App\Events\CheckoutableCheckedIn($asset, $oldTarget, $adminUser, $checkinNote, $checkin_at, $originalValues));
        }

        // STEP 2: Tentukan Target Model Peminjam (User atau Location)
        $targetModel = null;
        $targetDisplayName = '';
        $finalLocationId = null;
        $finalCompanyId = null;
        $userProfileUpdated = false;

        if ($targetType === 'location') {
            $targetModel = \App\Models\Location::find($targetId);
            if (!$targetModel) {
                return response()->json(['error' => 'Lokasi dengan ID ' . $targetId . ' tidak ditemukan!'], 404);
            }
            $targetDisplayName = $targetModel->name;
            $finalLocationId = $targetId;
            $finalCompanyId = $customCompanyId ?: ($targetModel->company_id ?: null);
        } else {
            $targetModel = \App\Models\User::find($targetId);
            if (!$targetModel) {
                return response()->json(['error' => 'User/Karyawan dengan ID ' . $targetId . ' tidak ditemukan!'], 404);
            }
            $targetDisplayName = trim($targetModel->first_name . ' ' . $targetModel->last_name);
            $finalLocationId = $customLocationId ?: ($targetModel->location_id ?: $asset->location_id);
            $finalCompanyId = $customCompanyId ?: ($targetModel->company_id ?: null);

            // Update profil karyawan jika dicentang
            if ($syncUserProfile && $targetModel) {
                $userChanged = false;
                if ($customCompanyId && $targetModel->company_id != $customCompanyId) {
                    $targetModel->company_id = $customCompanyId;
                    $userChanged = true;
                }
                if ($customLocationId && $targetModel->location_id != $customLocationId) {
                    $targetModel->location_id = $customLocationId;
                    $userChanged = true;
                }
                if ($userChanged) {
                    $targetModel->save();
                    $userProfileUpdated = true;
                }
            }
        }

        // Format tanggal pengembalian
        $expectedCheckinFormatted = null;
        if (!empty($expectedCheckin)) {
            $expectedCheckinFormatted = date('Y-m-d 17:00:00', strtotime($expectedCheckin));
        }

        // Susun Catatan Peminjaman
        $loanPrefix = '[PINJAM CEPAT] ';
        if (!empty($expectedCheckin)) {
            $loanPrefix .= '(Rencana Kembali: ' . date('d M Y', strtotime($expectedCheckin)) . ') ';
        }
        $checkoutNote = $loanPrefix . ($notes ?: ('Peminjaman unit kepada ' . $targetDisplayName));

        // STEP 3: Eksekusi checkout standar Snipe-IT
        $asset->checkOut($targetModel, $adminUser, now(), $expectedCheckinFormatted, $checkoutNote, $asset->name, $finalLocationId);

        // Set Status ke "Asset Dipinjamkan" (ID: 14)
        $asset->status_id = 14;
        if ($expectedCheckinFormatted) {
            $asset->expected_checkin = $expectedCheckinFormatted;
        }
        if ($finalLocationId) {
            $asset->location_id = $finalLocationId;
        }
        if ($finalCompanyId) {
            $asset->company_id = $finalCompanyId;
        }
        $asset->save();

        // Update catatan di Actionlog terbaru
        $latestLog = \App\Models\Actionlog::where('item_type', \App\Models\Asset::class)
            ->where('item_id', $asset->id)
            ->latest('id')
            ->first();
        if ($latestLog) {
            $latestLog->note = $checkoutNote;
            if ($expectedCheckinFormatted) {
                $latestLog->expected_checkin = $expectedCheckinFormatted;
            }
            $latestLog->save();
        }

        $locObj = $finalLocationId ? \App\Models\Location::find($finalLocationId) : null;
        $compObj = $asset->company_id ? \App\Models\Company::find($asset->company_id) : null;

        return response()->json([
            'success' => 'Aset berhasil dicatat dipinjamkan ke: ' . $targetDisplayName,
            'asset_name' => $asset->name,
            'asset_tag' => $asset->asset_tag,
            'target_name' => $targetDisplayName,
            'target_type' => $targetType,
            'expected_checkin' => $expectedCheckin ? date('d-m-Y', strtotime($expectedCheckin)) : null,
            'location_name' => $locObj ? $locObj->name : '-',
            'company_name' => $compObj ? $compObj->name : '-',
            'user_profile_updated' => $userProfileUpdated
        ]);
    })->name('custom.loan_checkout.process');

    // Modul Pengembalian Aset Pinjaman (Kembali ke Ruang IT / Stock)
    Route::post('/custom/loan-checkin', function(Illuminate\Http\Request $request) {
        $tag = trim($request->input('asset_tag'));
        $locationId = $request->input('location_id') ?: 36; // Default ID 36: RUANG OFFICE IT
        $statusId = $request->input('status_id') ?: 2; // Default ID 2: Asset Stock
        $notes = trim($request->input('notes'));

        if (empty($tag)) {
            return response()->json(['error' => 'Tag Aset atau Serial Number tidak boleh kosong!'], 422);
        }

        $asset = App\Models\Asset::where('asset_tag', $tag)->orWhere('serial', $tag)->first();
        if (!$asset) {
            return response()->json(['error' => 'Aset dengan tag ' . $tag . ' tidak ditemukan!'], 404);
        }

        $adminUser = auth()->user() ?: \App\Models\User::find(2);
        $oldTarget = $asset->assignedTo;
        $borrowerName = '-';
        if ($oldTarget) {
            $borrowerName = ($asset->assigned_type == 'App\\Models\\User') 
                ? trim($oldTarget->first_name . ' ' . $oldTarget->last_name) 
                : $oldTarget->name;
        }

        $checkinNote = '[PENGEMBALIAN PINJAM] ' . ($notes ?: ('Pengembalian aset pinjaman dari ' . $borrowerName . ' ke IT Stock'));

        // Standar Check-in Snipe-IT
        $originalValues = $asset->getRawOriginal();
        $checkin_at = date('Y-m-d H:i:s');
        $asset->expected_checkin = null;
        $asset->assignedTo()->disassociate($asset);
        $asset->accepted = null;
        $asset->last_checkin = $checkin_at;
        $asset->status_id = $statusId;
        if ($locationId) {
            $asset->location_id = $locationId;
            $asset->rtd_location_id = $locationId;
        }

        // Standard Cleanup: License Seats & Checkout Acceptances
        if (!empty($asset->licenseseats)) {
            $asset->licenseseats->each(function ($seat) {
                $seat->update(['assigned_to' => null]);
            });
        }
        $acceptances = \App\Models\CheckoutAcceptance::pending()->whereHasMorph('checkoutable',
            [\App\Models\Asset::class],
            function ($query) use ($asset) {
                $query->where('id', $asset->id);
            })->get();
        $acceptances->map(function ($acceptance) {
            $acceptance->delete();
        });

        $asset->save();

        event(new \App\Events\CheckoutableCheckedIn($asset, $oldTarget, $adminUser, $checkinNote, $checkin_at, $originalValues));

        // Pastikan catatan tersimpan di Actionlog
        $latestLog = \App\Models\Actionlog::where('item_type', \App\Models\Asset::class)
            ->where('item_id', $asset->id)
            ->latest('id')
            ->first();
        if ($latestLog) {
            $latestLog->note = $checkinNote;
            $latestLog->save();
        }

        $locObj = $locationId ? \App\Models\Location::find($locationId) : null;
        $statusObj = \App\Models\Statuslabel::find($statusId);

        return response()->json([
            'success' => 'Aset pinjaman berhasil dikembalikan ke: ' . ($locObj ? $locObj->name : 'Stock IT'),
            'asset_name' => $asset->name,
            'asset_tag' => $asset->asset_tag,
            'borrower_name' => $borrowerName,
            'status_name' => $statusObj ? $statusObj->name : 'Asset Stock',
            'location_name' => $locObj ? $locObj->name : '-'
        ]);
    })->name('custom.loan_checkin.process');
});

