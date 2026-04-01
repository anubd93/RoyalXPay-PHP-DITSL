<?php

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Set default controller and method
$routes->setDefaultController('AuthController');
$routes->setDefaultMethod('index');
// $routes->set404Override('App\Controllers\Error404::index');

/*
| --------------------------------------------------------------------
| FRONTEND ROUTES
| --------------------------------------------------------------------
*/

$routes->get('/', 'HomeController::index');
$routes->get('products/rent', 'HomeController::showRentProducts');
$routes->get('products/sale', 'HomeController::showSaleProducts');
$routes->get('products/details/(:segment)', 'HomeController::showProductDetail/$1');
$routes->get('sale/products/details/(:segment)', 'HomeController::saleProductDetails/$1');

// $routes->get('contact-us', 'PageController::contact');
$routes->post('save-contact', 'PageController::submitContactForm');

$routes->post('login/verify', 'AuthenticationController::verifyLogin');
// $routes->post('register', 'AuthenticationController::register');
$routes->get('logout', 'AuthenticationController::logout');

$routes->get('cart', 'CartController::index');
$routes->post('cart/add', 'CartController::add');
$routes->post('cart/update/(:any)', 'CartController::update/$1');
$routes->get('cart/remove/(:any)', 'CartController::remove/$1');

$routes->get('wishlist', 'HomeController::wishlist');
$routes->get('checkout', 'CheckoutController::index');
$routes->post('checkout/placeOrder', 'CheckoutController::placeOrder');
$routes->get('checkout/success/(:num)', 'CheckoutController::success/$1');

$routes->group('user', function ($routes) {
    $routes->get('dashboard', 'UserDashboardController::index');
    $routes->get('profile', 'UserDashboardController::profile');
    $routes->post('profile/update', 'UserDashboardController::updateProfile');

    $routes->get('orders', 'UserDashboardController::orders');
    $routes->get('orders/view/(:num)', 'UserDashboardController::viewOrderDetails/$1');

    $routes->get('logout', 'AuthenticationController::logout');
    $routes->get('profile', 'AuthenticationController::profile');
    $routes->get('change-password', 'AuthenticationController::changePassword');
    $routes->post('update-password', 'AuthenticationController::UpdatePassword');
});

$routes->group('employees', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'EmployeeController::index');
    $routes->get('create', 'EmployeeController::create');
    $routes->post('save', 'EmployeeController::store');
    $routes->get('edit/(:num)', 'EmployeeController::edit/$1');
    $routes->get('view/(:num)', 'EmployeeController::view/$1');
    $routes->post('delete', 'EmployeeController::delete');
    $routes->get('get-attendance', 'EmployeeController::getAttendance');
    $routes->get('attendance-calendar', 'EmployeeController::getAttendanceCalendar');
});

//mobile api
$routes->post('api/Auth/login', 'Api\Auth::login');
$routes->post('api/Auth/verify-otp', 'Api\Auth::verifyOtp');

$routes->post('api/dashboard', 'Api\Auth::dashboardData');
$routes->post('api/wallet-report', 'Api\Auth::walletReport');
$routes->post('api/RechargeRequest', 'Api\Auth::RechargeRequest');
$routes->get('api/merchant-notifications', 'Api\Auth::getMerchantNotifications');

$routes->post('api/aadc/fetch-bill-postman', 'Api\Aadc::fetchBillFromPostman');
$routes->post('api/aadc/pay-postman', 'Api\Aadc::makePaymentFromPostman');

$routes->post('api/addc/fetch-bill-postman', 'Api\Addc::fetchBillFromPostman');
$routes->post('api/addc/pay-postman', 'Api\Addc::makePaymentFromPostman');

$routes->post('api/sergas/fetch-bill-postman', 'Api\Sergas::fetchBillFromPostman');
$routes->post('api/sergas/pay-postman', 'Api\Sergas::makePaymentFromPostman');

$routes->post('api/salikdirect/fetch-bill-postman', 'Api\Salikdirect::fetchBillFromPostman');
$routes->post('api/salikdirect/pay-postman', 'Api\Salikdirect::makePaymentFromPostman');

$routes->post('api/hafilat/fetch-bill-postman', 'Api\Hafilat::fetchBillFromPostman');
$routes->post('api/hafilat/pay-postman', 'Api\Hafilat::makePaymentFromPostman');

$routes->post('api/fewa/fetch-bill-postman', 'Api\Fewa::fetchBillFromPostman');
$routes->post('api/fewa/pay-postman', 'Api\Fewa::makePaymentFromPostman');

$routes->post('api/etisalat/fetch-bill-postman', 'Api\Etisalat::fetchBillFromPostman');
$routes->post('api/etisalat/pay-postman', 'Api\Etisalat::makePaymentFromPostman');

$routes->post('api/onlinecharaty/pay-postman', 'Api\Onlinecharaty::makePaymentFromPostman');

$routes->post('api/nationalbond/fetch-bill-postman', 'Api\Nationalbond::fetchBillFromPostman');
$routes->post('api/nationalbond/pay-postman', 'Api\Nationalbond::makePaymentFromPostman');

$routes->post('api/mawaqif/fetch-bill-postman', 'Api\Mawaqif::fetchBillFromPostman');
$routes->post('api/mawaqif/pay-postman', 'Api\Mawaqif::makePaymentFromPostman');

$routes->post('api/dutopup/fetch-bill-postman', 'Api\Dutopup::fetchBillFromPostman');
$routes->post('api/dutopup/pay-postman', 'Api\Dutopup::makePaymentFromPostman');

$routes->post('api/noltopup/fetch-bill-postman', 'Api\Noltopup::fetchBillFromPostman');
$routes->post('api/noltopup/pay-postman', 'Api\Noltopup::makePaymentFromPostman');

$routes->post('api/dupostpaid/fetch-bill-postman', 'Api\Dupostpaid::fetchBillFromPostman');
$routes->post('api/dupostpaid/pay-postman', 'Api\Dupostpaid::makePaymentFromPostman');

$routes->post('api/internationrecharge/fetch-bill-postman', 'Api\Internationrecharge::fetchBillFromPostman');
$routes->post('api/internationrecharge/pay-postman', 'Api\Internationrecharge::makePaymentFromPostman');

$routes->post('api/ajmandirect/fetch-bill-postman', 'Api\Ajmandirect::fetchBillFromPostman');
$routes->post('api/ajmandirect/pay-postman', 'Api\Ajmandirect::makePaymentFromPostman');

$routes->post('api/lootahgas/fetch-bill-postman', 'Api\Lootahgas::fetchBillFromPostman');
$routes->post('api/lootahgas/pay-postman', 'Api\Lootahgas::makePaymentFromPostman');

$routes->post('api/dubaided/fetch-bill-postman', 'Api\Dubaided::fetchBillFromPostman');
$routes->post('api/dubaided/pay-postman', 'Api\Dubaided::makePaymentFromPostman');

$routes->post('api/offlinecharity/fetch-bill-postman', 'Api\Offlinecharity::fetchBillFromPostman');
$routes->post('api/offlinecharity/pay-postman', 'Api\Offlinecharity::makePaymentFromPostman');


$routes->get('login', 'AuthController::index');
$routes->get('generate-pdf', 'PdfController::generate');
$routes->post('verify-login', 'AuthController::verifyLogin');

$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('settings', 'Settings::index');
    $routes->get('dashboard', 'DashboardController::index');
    $routes->get('logout', 'AuthController::logout');
    $routes->get('profile', 'AuthController::profile');
    $routes->get('change-password', 'AuthController::changePassword');
    $routes->post('update-password', 'AuthController::UpdatePassword');
});

$routes->group('customers', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'CustomerController::index'); // All Customer
    $routes->get('add', 'CustomerController::add');
    $routes->post('save', 'CustomerController::save');
    $routes->get('edit/(:num)', 'CustomerController::edit/$1');
    $routes->post('delete', 'CustomerController::delete');
    $routes->get('preview/(:num)', 'CustomerController::show/$1');
    $routes->post('add-payment', 'CustomerController::add_amount');
$routes->get('paid-customers', 'CustomerController::paidCustomers');
    // Payments
    $routes->get('payment-history/(:num)', 'CustomerPaymentController::history/$1');
    // $routes->get('add-payment/(:num)', 'CustomerPaymentController::add/$1');
    $routes->post('save-payment', 'CustomerPaymentController::save');
    $routes->get('invoice/(:num)', 'CustomerPaymentController::invoice/$1');
});

$routes->group('merchant', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'MerchantController::index');
    $routes->post('save', 'MerchantController::save');
    $routes->get('edit/(:num)', 'MerchantController::edit/$1');
    $routes->post('delete', 'MerchantController::delete');
    $routes->get('preview/(:num)', 'MerchantController::showDetails/$1');
});
$routes->post('api/general/merchant-wallet-balance', 'Api\GeneralApiController::getMerchantWalletBalance');


$routes->group('employee-attendance', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AttendanceController::index');
    $routes->get('view/(:num)', 'AttendanceController::getEmployeeAttendance/$1');
});


$routes->group('employee-tasks', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'TaskController::index');
    $routes->get('create', 'TaskController::create');
    $routes->get('edit/(:num)', 'TaskController::edit/$1');
    $routes->post('save', 'TaskController::save');
    $routes->get('preview/(:num)', 'TaskController::preview/$1');
    $routes->post('delete', 'TaskController::delete');
    $routes->post('update-status', 'TaskController::updateStatus');
});

// Create new location record
    $routes->post('assign-task', 'TaskController::assignTask');
    $routes->post('submit-task', 'TaskController::submitTask');
    $routes->get('get-assign-tasks', 'TaskController::getTasksByDate');
    $routes->get('get-juniors-employees', 'EmployeeController::getJuniorsEmployees');
     $routes->post('employee-locations', 'LocationController::create');
    $routes->post('employee/register-or-get', 'EmployeeController::registerOrGetEmployee');
    $routes->get('employee-locations/last/(:num)', 'LocationController::getLastEmployeeLocation/$1');
    $routes->get('payslip/serve/(:num)/(:num)/(:num)', 'PayslipController::servePayslip/$1/$2/$3');

    $routes->get('employee-locations', 'TrackingController::index');
$routes->get('employee-locations/view/(:num)', 'TrackingController::getEmployeeLocation/$1');
$routes->post('employee-locations/delete', 'TrackingController::delete');

$routes->group('salary', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SalaryController::index');
    $routes->get('create', 'SalaryController::create');
    $routes->post('store', 'SalaryController::store');
    $routes->get('edit/(:num)', 'SalaryController::edit/$1');
    $routes->post('delete', 'SalaryController::delete');
    $routes->get('slip/view/(:num)', 'SalarySlipController::view/$1');
    $routes->get('slip/download/(:num)', 'SalarySlipController::download/$1');
});


$routes->group('subscription', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SubscriptionController::index');
    $routes->post('save', 'SubscriptionController::save');
    $routes->get('edit/(:num)', 'SubscriptionController::edit/$1');
    $routes->get('delete/(:num)', 'SubscriptionController::delete/$1');
});

// //Notifications routes start
// $routes->group('notifications', ['filter' => 'auth'], function ($routes) {
//     $routes->get('/', 'NotificationController::index');
//     $routes->post('save', 'NotificationController::save');
//     $routes->get('edit/(:num)', 'NotificationController::edit/$1');
//     $routes->get('delete/(:num)', 'NotificationController::delete/$1');
//     $routes->get('preview/(:num)', 'NotificationController::showDetails/$1');
// });
//start Frontend
$routes->get('terms-conditions', 'Frontend::termsConditions');
$routes->get('search-page', 'Frontend::searchPage');
$routes->get('menu-page', 'Frontend::menupage');
$routes->get('recharge', 'Frontend::recharge');
$routes->get('contact-us', 'Frontend::contactus');
$routes->get('contract_us', 'Frontend::contact-us');
$routes->get('blog', 'Frontend::index');
$routes->get('search-page.html', 'Frontend::searchPage');
$routes->get('menu-page.html', 'Frontend::menupage');
$routes->get('recharge.html', 'Frontend::recharge');
$routes->get('contact-us.html', 'Frontend::contactus');


$routes->get('discount-loyalities', 'Frontend::discountloyalities');
$routes->get('company', 'Frontend::company');
$routes->get('payment-services', 'Frontend::paymentservices');
$routes->get('recharge-bill', 'Frontend::rechargebill');
$routes->get('wealth', 'Frontend::wealth');
$routes->get('discount-loyalities.html', 'Frontend::discountloyalities');
$routes->get('company.html', 'Frontend::company');
$routes->get('payment-services.html', 'Frontend::paymentservices');
$routes->get('recharge-bill.html', 'Frontend::rechargebill');
$routes->get('wealth.html', 'Frontend::wealth');

$routes->get('chat.php', 'Frontend::chat');
$routes->get('call.php', 'Frontend::call');
$routes->get('video-call.php', 'Frontend::videocall');

$routes->get('chat', 'Frontend::chat');
$routes->get('call', 'Frontend::call');
$routes->get('videocall', 'Frontend::videocall');
// AI chat proxy routes
$routes->match(['get', 'post'], 'proxy/token', 'Frontend::proxy');
$routes->match(['get', 'post'], 'proxy', 'Frontend::proxy'); // optional duplicate

//end Frontend
$routes->get('index', 'Frontend::index');

$routes->group('banking', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Banking\BankingController::index');
    $routes->get('transfer-to-bank', 'Banking\BankingController::transferToBank');
    $routes->get('transfer-to-mobile', 'Banking\BankingController::transferToMobile');
    $routes->get('transaction-history', 'Banking\BankingController::transactionHistory');
});

$routes->group('bills', ['filter' => 'auth'], function($routes) {
    $routes->get('electricity', 'Admin\BillsController::electricity');
    $routes->get('mobile-recharge', 'Admin\BillsController::mobileRecharge');
    $routes->get('dth', 'Admin\BillsController::dth');
    $routes->get('fastag', 'Admin\BillsController::fastag');
    $routes->get('metro', 'Admin\BillsController::metro');
    // ...add other routes similarly
});



$routes->group('product-master', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'ProductController::index');
    $routes->post('create', 'ProductController::create');
    $routes->get('edit/(:num)', 'ProductController::edit/$1');
    $routes->post('update', 'ProductController::update');
    $routes->get('preview/(:num)', 'ProductController::showDetails/$1');
    $routes->get('delete/(:num)', 'ProductController::delete/$1');
});

$routes->get('get-products-details', 'ProductController::getProductsRows/$1');

$routes->group('rent-products', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'RentProductController::index');
    $routes->post('save', 'RentProductController::store');
    $routes->get('create', 'RentProductController::create');
    $routes->get('edit/(:num)', 'RentProductController::edit/$1');
    $routes->get('delete/(:num)', 'RentProductController::delete/$1');
    $routes->get('preview/(:num)', 'RentProductController::showDetails/$1');
});

$routes->group('sale-products', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'SaleProductController::index');
    $routes->get('create', 'SaleProductController::create');
    $routes->post('save', 'SaleProductController::store');
    $routes->get('edit/(:num)', 'SaleProductController::edit/$1');
    $routes->get('delete/(:num)', 'SaleProductController::delete/$1');
    $routes->get('preview/(:num)', 'SaleProductController::showDetails/$1');
});

$routes->group('companies', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'CompanyController::index');
    $routes->post('save', 'CompanyController::save');
    $routes->get('edit/(:num)', 'CompanyController::edit/$1');
    $routes->post('delete', 'CompanyController::delete');
    $routes->get('preview/(:num)', 'CompanyController::showDetails/$1');
});

$routes->group('request-letters', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'RequestLetterController::index');
    $routes->get('create', 'RequestLetterController::create');
    $routes->get('edit', 'RequestLetterController::edit');
    $routes->post('save', 'RequestLetterController::save');
    $routes->get('preview', 'RequestLetterController::preview');
    $routes->post('delete', 'RequestLetterController::delete');
});




 $routes->get('employees/details', 'EmployeeController::getEmployeeByCode/$1');
    $routes->get('get-reporting-managers', 'ManagerController::getReportingManagersByCompany');

$routes->group('orders', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'OrderController::index');
    $routes->post('save', 'OrderController::save');
    $routes->get('edit/(:num)', 'OrderController::edit/$1');
    $routes->post('delete', 'OrderController::delete');
    $routes->get('preview/(:num)', 'OrderController::viewOrderDetails/$1');
});

$routes->group('purchases', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PurchaseController::index');
    $routes->get('create', 'PurchaseController::create');
    $routes->post('save', 'PurchaseController::save');
    $routes->get('edit/(:num)', 'PurchaseController::edit/$1');
    $routes->post('delete', 'PurchaseController::delete');
    $routes->get('preview/(:num)', 'PurchaseController::showDetails/$1');
});

$routes->group('invoices', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'InvoiceController::index');
    $routes->post('save', 'InvoiceController::save');
    $routes->get('edit/(:num)', 'InvoiceController::edit/$1');
    $routes->post('delete', 'InvoiceController::delete');
    $routes->get('preview/(:num)', 'InvoiceController::showDetails/$1');
});

$routes->group('delivery-times', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DeliveryController::index');
    $routes->post('save', 'DeliveryController::save');
    $routes->get('edit/(:num)', 'DeliveryController::edit/$1');
    $routes->get('delete/(:num)', 'DeliveryController::delete/$1');
});

$routes->group('product-types', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ProductTypeController::index');
    $routes->post('save', 'ProductTypeController::save');
    $routes->get('edit/(:num)', 'ProductTypeController::edit/$1');
    $routes->get('delete/(:num)', 'ProductTypeController::delete/$1');
});

$routes->group('colors', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ColorsController::index');
    $routes->post('save', 'ColorsController::save');
    $routes->get('edit/(:num)', 'ColorsController::edit/$1');
    $routes->get('delete/(:num)', 'ColorsController::delete/$1');
});

$routes->group('banks', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'BanksController::index');
    $routes->post('save', 'BanksController::save');
    $routes->get('edit/(:num)', 'BanksController::edit/$1');
    $routes->get('delete/(:num)', 'BanksController::delete/$1');
});

$routes->group('sizes', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SizesController::index');
    $routes->post('save', 'SizesController::save');
    $routes->get('edit/(:num)', 'SizesController::edit/$1');
    $routes->get('delete/(:num)', 'SizesController::delete/$1');
});

$routes->group('touch-types', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'TouchTypesController::index');
    $routes->post('save', 'TouchTypesController::save');
    $routes->get('edit/(:num)', 'TouchTypesController::edit/$1');
    $routes->get('delete/(:num)', 'TouchTypesController::delete/$1');
});

$routes->group('resolutions', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ResolutionController::index');
    $routes->post('save', 'ResolutionController::save');
    $routes->get('edit/(:num)', 'ResolutionController::edit/$1');
    $routes->get('delete/(:num)', 'ResolutionController::delete/$1');
});

$routes->group('glass-types', ['filter' => 'auth'], function ($routes) {
    // Display the list of glass types
    $routes->get('/', 'GlassTypesController::index');
    $routes->post('save', 'GlassTypesController::save');
    $routes->get('edit/(:num)', 'GlassTypesController::edit/$1');
    $routes->get('delete/(:num)', 'GlassTypesController::delete/$1');
});

$routes->group('terms-and-conditions', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'TermsAndConditionsController::index');
    $routes->post('save', 'TermsAndConditionsController::save');
    $routes->get('edit/(:num)', 'TermsAndConditionsController::edit/$1');
    $routes->get('delete/(:num)', 'TermsAndConditionsController::delete/$1');
});

$routes->group('rent-quotations', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'RentQuotationController::index');
    $routes->get('create', 'RentQuotationController::create');
    $routes->post('save', 'RentQuotationController::store');
    $routes->get('edit/(:num)', 'RentQuotationController::edit/$1');
    $routes->get('delete/(:num)', 'RentQuotationController::delete/$1');
    $routes->get('preview/(:num)', 'RentQuotationController::showDetails/$1');
    $routes->get('generate-quotations/(:num)', 'RentQuotationController::generateQuotation/$1');
    $routes->get('fetch-rent-products', 'RentQuotationController::fetchRentProducts');
});

$routes->group('rent-contracts', ['filter' => 'auth'], function ($routes) {
    // Routes for Rent Contracts
    $routes->get('/', 'RentContractController::index');
    $routes->get('create', 'RentContractController::create');
    $routes->post('save', 'RentContractController::saveContract');
    $routes->get('edit/(:num)', 'RentContractController::edit/$1');
    $routes->get('fetch', 'RentContractController::fetchRentProducts');
    $routes->get('delete/(:num)', 'RentContractController::delete/$1');
    $routes->get('preview/(:num)', 'RentContractController::showDetails/$1');
    $routes->get('generate-pdf/(:num)', 'RentContractController::generatePDF/$1');
    $routes->get('generate-invoice/(:num)', 'RentContractController::generateInvoice/$1');
});

$routes->group('contract-payment-history', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PaymentController::index');
    $routes->post('save', 'PaymentController::save');
    $routes->get('edit/(:num)', 'PaymentController::edit/$1');
    $routes->get('delete/(:num)', 'PaymentController::delete/$1');
});

$routes->get('/generate-invoice/(:num)', 'PaymentController::generateInvoice/$1');

$routes->group('contract-delivery-history', ['filter' => 'auth'], function ($routes) {
    // List deliveries for a contract
    $routes->get('/', 'ContractDeliveryController::index');
    $routes->post('save', 'ContractDeliveryController::save');
    $routes->get('edit/(:num)', 'ContractDeliveryController::edit/$1');
    $routes->get('delete/(:num)', 'ContractDeliveryController::delete/$1');
});

$routes->group('sale-quotations', ['filter' => 'auth'], function ($routes) {

    $routes->get('/', 'SaleQuotationController::index');
    $routes->get('create', 'SaleQuotationController::create');
    $routes->post('save', 'SaleQuotationController::saveQuotation');
    $routes->get('edit/(:num)', 'SaleQuotationController::edit/$1');
    $routes->get('delete/(:num)', 'SaleQuotationController::delete/$1');
    $routes->get('preview/(:num)', 'SaleQuotationController::showDetails/$1');
    $routes->get('getProductsRows', 'SaleQuotationController::getProductsRows');
    $routes->get('generate-quotations/(:num)', 'SaleQuotationController::generateQuotation/$1');
});

$routes->group('sale-contracts', ['filter' => 'auth'], function ($routes) {
    // Routes for Rent Contracts
    $routes->get('/', 'SaleContractController::index');
    $routes->get('create', 'SaleContractController::create');
    $routes->post('save', 'SaleContractController::saveContract');
    $routes->get('edit/(:num)', 'SaleContractController::edit/$1');
    $routes->get('delete/(:num)', 'SaleContractController::delete/$1');
    $routes->get('preview/(:num)', 'SaleContractController::showDetails/$1');
    $routes->get('getProductsRows', 'SaleContractController::getProductsRows');
    $routes->get('generate-pdf/(:num)', 'SaleContractController::generatePDF/$1');
    $routes->get('generate-invoice/(:num)', 'SaleContractController::generateInvoice/$1');
});

$routes->get('send-notification', 'HomeController::testNotification');

$routes->get('feedback', 'CommonController::feedbacks');
$routes->post('feedback/delete', 'CommonController::deleteFeedback');

$routes->get('company-info', 'CompanyInfoController::index');
$routes->post('save-company-info', 'CompanyInfoController::store');

$routes->group('reports', ['filter' => 'auth'], function ($routes) {
    // List deliveries for a contract
    $routes->get('customer-report', 'ReportsController::index');
    $routes->get('rent-product', 'ReportsController::rentProductReport');
    $routes->get('sale-product', 'ReportsController::saleProductReport');
});

$routes->group('roles', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'RoleController::index');
    $routes->post('save', 'RoleController::save');
    $routes->get('edit/(:num)', 'RoleController::edit/$1');
    $routes->get('delete/(:num)', 'RoleController::delete/$1');
});

$routes->group('modules', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ModuleController::index');
    $routes->post('save', 'ModuleController::save');
    $routes->get('edit/(:num)', 'ModuleController::edit/$1');
    $routes->get('delete/(:num)', 'ModuleController::delete/$1');
    $routes->get('getSubmodules', 'ModuleController::getSubmodules');
});

$routes->group('submodules', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'SubmoduleController::index');
    $routes->post('save', 'SubmoduleController::save');
    $routes->get('edit/(:num)', 'SubmoduleController::edit/$1');
    $routes->get('delete/(:num)', 'SubmoduleController::delete/$1');
});

$routes->get('merchant/privileges/(:num)', 'MerchantController::privileges/$1');
$routes->post('merchant/savePrivileges', 'MerchantController::savePrivileges');

$routes->group('permissions', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PermissionController::index');
    $routes->post('save', 'PermissionController::save');
    $routes->get('edit/(:num)', 'PermissionController::edit/$1');
    $routes->get('delete/(:num)', 'PermissionController::delete/$1');
});


$routes->post('customer-auth/login', 'CustomerAuth::login');
$routes->post('customer-auth/register', 'CustomerAuth::register');
$routes->get('customer-auth/logout', 'CustomerAuth::logout');

// Optional for testing from browser (not needed for AJAX login)
$routes->get('customer-auth/login', 'CustomerAuth::login');

$routes->get('admin/transaction-report', 'TransactionReport::index');


$routes->group('api/aadc-payment', function($routes) {
    $routes->get('/', 'Api\AadcPayment::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\AadcPayment::getToken'); // Token generation
    $routes->post('make-payment', 'Api\AadcPayment::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\AadcPayment::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\AadcPayment::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\AadcPayment::transactionReport'); // For reports/status
});

$routes->group('api/addc-payment', function($routes) {
    $routes->get('/', 'Api\AddcPayment::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\AddcPayment::getToken'); // Token generation
    $routes->post('make-payment', 'Api\AddcPayment::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\AddcPayment::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\AddcPayment::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\AddcPayment::transactionReport'); // For reports/status
});

$routes->group('api/aadc', function($routes) {
    $routes->get('/', 'Api\Aadc::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Aadc::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Aadc::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Aadc::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Aadc::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Aadc::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Aadc::reports');
});


    $routes->get('api/addc/reports', 'Api\Addc::reports');


    $routes->group('api/addc', function($routes) {
    $routes->get('/', 'Api\Addc::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Addc::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Addc::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Addc::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Addc::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Addc::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Addc::reports');
});


    $routes->get('api/addc/reports', 'Api\Addc::reports');

$routes->get('add-wallet', 'WalletController::create');

$routes->get('manage-wallet', 'WalletController::index');
$routes->get('edit-wallet/(:num)', 'WalletController::edit/$1');
$routes->post('update-wallet', 'WalletController::update');
$routes->post('store-wallet', 'WalletController::store');

$routes->group('admin', function ($routes) {
    $routes->post('store-wallet', 'WalletController::store');
});


$routes->get('wallet-history/(:num)', 'MerchantWalletController::history/$1');

$routes->get('register', 'AuthController::register');
$routes->post('registerSave', 'AuthController::registerSave');
$routes->get('customers/payment_history/(:num)', 'CustomerController::payment_history/$1');
$routes->post('send-otp', 'AuthController::sendOtp');
// OTP page
$routes->get('verify-otp', 'AuthController::otpForm');
// Resent otp
$routes->get('resend-otp', 'AuthController::resendOtp');
// Verify otp
$routes->post('verify-otp', 'AuthController::verifyOtp');

//aadc
    $routes->get('api/aadc/receipt/(:num)', 'Api\Aadc::receipt/$1');

  

    //nol topup
    $routes->get('api/noltopup/reports', 'Api\Noltopup::reports');


    $routes->group('api/noltopup', function($routes) {
    $routes->get('/', 'Api\Noltopup::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Noltopup::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Noltopup::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Noltopup::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Noltopup::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Noltopup::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Noltopup::reports');
    
});

 $routes->get('api/noltopup/receipt/(:num)', 'Api\Noltopup::receipt/$1');


//end nol topup

//national bond
    $routes->get('api/nationalbond/reports', 'Api\Nationalbond::reports');


    $routes->group('api/nationalbond', function($routes) {
    $routes->get('/', 'Api\Nationalbond::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Nationalbond::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Nationalbond::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Nationalbond::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Nationalbond::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Nationalbond::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Nationalbond::reports');
    
});

 $routes->get('api/nationalbond/receipt/(:num)', 'Api\Nationalbond::receipt/$1');


//end national bond

//du topup
    $routes->get('api/dutopup/reports', 'Api\Dutopup::reports');


    $routes->group('api/dutopup', function($routes) {
    $routes->get('/', 'Api\Dutopup::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Dutopup::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Dutopup::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Dutopup::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Dutopup::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Dutopup::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Dutopup::reports');
    
});

 $routes->get('api/dutopup/receipt/(:num)', 'Api\Dutopup::receipt/$1');


//end du topup

//tahseel
    $routes->get('api/tahseel/reports', 'Api\Tahseel::reports');


    $routes->group('api/tahseel', function($routes) {
    $routes->get('/', 'Api\Tahseel::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Tahseel::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Tahseel::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Tahseel::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Tahseel::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Tahseel::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Tahseel::reports');
    
});

 $routes->get('api/tahseel/receipt/(:num)', 'Api\Tahseel::receipt/$1');

//end tahseel

//tahseel
    $routes->get('api/salikdirect/reports', 'Api\Salikdirect::reports');


    $routes->group('api/salikdirect', function($routes) {
    $routes->get('/', 'Api\Salikdirect::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Salikdirect::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Salikdirect::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Salikdirect::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Salikdirect::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Salikdirect::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Salikdirect::reports');
    
});

 $routes->get('api/salikdirect/receipt/(:num)', 'Api\Tahseel::receipt/$1');


//end tahseel

//Ajmandirect
    $routes->get('api/ajmandirect/reports', 'Api\Ajmandirect::reports');


    $routes->group('api/ajmandirect', function($routes) {
    $routes->get('/', 'Api\Ajmandirect::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Ajmandirect::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Ajmandirect::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Ajmandirect::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Ajmandirect::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Ajmandirect::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Ajmandirect::reports');
    
});

 $routes->get('api/ajmandirect/receipt/(:num)', 'Api\Ajmandirect::receipt/$1');


//end Ajmandirect

//Dubaided
    $routes->get('api/dubaided/reports', 'Api\Dubaided::reports');


    $routes->group('api/dubaided', function($routes) {
    $routes->get('/', 'Api\Dubaided::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Dubaided::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Dubaided::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Dubaided::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Dubaided::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Dubaided::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Dubaided::reports');
    
});

 $routes->get('api/dubaided/receipt/(:num)', 'Api\Dubaided::receipt/$1');


//end Dubaided


//lootahgas
    $routes->get('api/lootahgas/reports', 'Api\Lootahgas::reports');


    $routes->group('api/lootahgas', function($routes) {
    $routes->get('/', 'Api\Lootahgas::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Lootahgas::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Lootahgas::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Lootahgas::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Lootahgas::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Lootahgas::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Lootahgas::reports');
    
});

 $routes->get('api/lootahgas/receipt/(:num)', 'Api\Lootahgas::receipt/$1');


//end lootahgas

//offlinecharity
    $routes->get('api/offlinecharity/reports', 'Api\Offlinecharity::reports');


    $routes->group('api/offlinecharity', function($routes) {
    $routes->get('/', 'Api\Offlinecharity::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Offlinecharity::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Offlinecharity::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Offlinecharity::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Offlinecharity::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Offlinecharity::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Offlinecharity::reports');
    
});

 $routes->get('api/offlinecharity/receipt/(:num)', 'Api\Offlinecharity::receipt/$1');


//end offlinecharity

//Dupostpaid
    $routes->get('api/dupostpaid/reports', 'Api\Salikdirect::reports');


    $routes->group('api/dupostpaid', function($routes) {
    $routes->get('/', 'Api\Dupostpaid::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Dupostpaid::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Dupostpaid::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Dupostpaid::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Dupostpaid::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Dupostpaid::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Dupostpaid::reports');
    
});

 $routes->get('api/dupostpaid/receipt/(:num)', 'Api\Dupostpaid::receipt/$1');


//end Dupostpaid

//dubai
    $routes->get('api/dubai/reports', 'Api\Dubai::reports');


    $routes->group('api/dubai', function($routes) {
    $routes->get('/', 'Api\Dubai::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Dubai::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Dubai::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Dubai::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Dubai::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Dubai::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Dubai::reports');
    
});

 $routes->get('api/dubai/receipt/(:num)', 'Api\Dubai::receipt/$1');


//end dubai

//onlinecharaty
    $routes->get('api/onlinecharaty/reports', 'Api\Onlinecharaty::reports');


    $routes->group('api/onlinecharaty', function($routes) {
    $routes->get('/', 'Api\Onlinecharaty::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Onlinecharaty::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Onlinecharaty::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Onlinecharaty::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Onlinecharaty::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Onlinecharaty::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Onlinecharaty::reports');
    
});

 $routes->get('api/onlinecharaty/receipt/(:num)', 'Api\Onlinecharaty::receipt/$1');


//end onlinecharaty

//fewa
    $routes->get('api/fewa/reports', 'Api\Fewa::reports');


    $routes->group('api/fewa', function($routes) {
    $routes->get('/', 'Api\Fewa::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Fewa::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Fewa::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Fewa::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Fewa::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Fewa::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Fewa::reports');
    
});

 $routes->get('api/fewa/receipt/(:num)', 'Api\Fewa::receipt/$1');


//end fewa

//hafilat
    $routes->get('api/hafilat/reports', 'Api\Hafilat::reports');


    $routes->group('api/hafilat', function($routes) {
    $routes->get('/', 'Api\Hafilat::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Hafilat::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Hafilat::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Hafilat::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Hafilat::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Hafilat::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Hafilat::reports');
    
});

 $routes->get('api/hafilat/receipt/(:num)', 'Api\Hafilat::receipt/$1');


//end hafilat Hafilat


//Etisalat
    $routes->get('api/etisalat/reports', 'Api\Etisalat::reports');


    $routes->group('api/etisalat', function($routes) {
    $routes->get('/', 'Api\Etisalat::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Etisalat::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Etisalat::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Etisalat::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Etisalat::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Etisalat::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Etisalat::reports');
    
});

 $routes->get('api/etisalat/receipt/(:num)', 'Api\Etisalat::receipt/$1');


//end Etisalat

//Mawaqif
    $routes->get('api/mawaqif/reports', 'Api\Mawaqif::reports');


    $routes->group('api/mawaqif', function($routes) {
    $routes->get('/', 'Api\Mawaqif::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Mawaqif::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Mawaqif::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Mawaqif::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Mawaqif::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Mawaqif::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Mawaqif::reports');
    
});

 $routes->get('api/mawaqif/receipt/(:num)', 'Api\Mawaqif::receipt/$1');


//end mawaqif

//sergas
    $routes->get('api/sergas/reports', 'Api\Sergas::reports');


    $routes->group('api/sergas', function($routes) {
    $routes->get('/', 'Api\Sergas::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Sergas::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Sergas::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Sergas::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Sergas::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Sergas::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Sergas::reports');
    
});

 $routes->get('api/sergas/receipt/(:num)', 'Api\Sergas::receipt/$1');


//end sergas

//upay
    $routes->get('api/upay/reports', 'Api\Upay::reports');


    $routes->group('api/upay', function($routes) {
    $routes->get('/', 'Api\Upay::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Upay::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Upay::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Upay::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Upay::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Upay::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Upay::reports');
    
});

 $routes->get('api/upay/receipt/(:num)', 'Api\Upay::receipt/$1');


//end Upay


//internation recharge
    $routes->get('api/internationrecharge/reports', 'Api\Internationrecharge::reports');


    $routes->group('api/internationrecharge', function($routes) {
    $routes->get('/', 'Api\Internationrecharge::index'); // Loads the HTML form (View)

    $routes->post('get-token', 'Api\Internationrecharge::getToken'); // Token generation
    $routes->post('make-payment', 'Api\Internationrecharge::makePayment'); // Main Payment API

    $routes->post('fetch-bill', 'Api\Internationrecharge::fetchBill'); // Optional if you add fetch bill separately
    $routes->get('balance', 'Api\Internationrecharge::walletBalance'); // Optional for wallet balance (merchant)
    $routes->post('transaction-report', 'Api\Internationrecharge::transactionReport'); // For reports/status
    $routes->get('reports', 'Api\Internationrecharge::reports');
    
});

 $routes->get('api/internationrecharge/receipt/(:num)', 'Api\Internationrecharge::receipt/$1');


//end internation recharge
$routes->get('manage-wallet/recharge', 'WalletController::rechargeForm');
$routes->post('manage-wallet/recharge', 'WalletController::saveRecharge');
$routes->get('manage-wallet/recharge-history', 'WalletController::rechargeHistory');
$routes->get('notifications', 'WalletController::fetchNotifications');
$routes->get('wallet/mark-done/(:num)', 'WalletController::markNotificationDone/$1');
$routes->post('notifications/mark-done/(:num)', 'WalletController::markNotificationDone/$1');
$routes->post('wallet/approve-recharge/(:num)', 'WalletController::approveRecharge/$1');
$routes->post('wallet/approve-recharge/(:num)', 'Admin\WalletController::approveRecharge/$1');

$routes->group('admin/norka', ['namespace' => 'App\Controllers'], function($routes) {
    $routes->get('insurance', 'NorkaController::insurance');
    $routes->get('care', 'NorkaController::care');
    $routes->post('save', 'NorkaController::save');
    $routes->post('delete/(:num)', 'NorkaController::delete/$1');
        $routes->get('roots', 'NorkaController::roots');  

});

$routes->post('admin/norka/update/(:num)', 'NorkaController::update/$1');


$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {

    $routes->get('companies', 'CompanyController::getCompanyList');
    $routes->get('companies/(:num)', 'CompanyController::getCompanyById/$1');
    $routes->put('companies/(:num)', 'CompanyController::updateCompanyDetails/$1');

    $routes->get('payment', 'PackageController::getPaymentUrl');
    $routes->get('payment/success', 'PackageController::success');
    $routes->get('payment/cancel', 'PackageController::cancel');
    $routes->get('payment/failure', 'PackageController::failure');

    // Create new location record
    $routes->post('assign-task', 'TaskController::assignTask');
    $routes->post('submit-task', 'TaskController::submitTask');
    $routes->get('get-assign-tasks', 'TaskController::getTasksByDate');
    $routes->get('get-juniors-employees', 'EmployeeController::getJuniorsEmployees');
    $routes->post('employee-locations', 'LocationController::create');
    $routes->get('employee-locations', 'LocationController::getEmployeeLocations');
    $routes->get('get-employee-last-locations', 'LocationController::getLastEmployeeLocation');
    $routes->post('employee/register-or-get', 'EmployeeController::registerOrGetEmployee');
    $routes->get('employee-locations/last/(:num)', 'LocationController::getLastEmployeeLocation/$1');
    $routes->get('payslip/serve/(:num)/(:num)/(:num)', 'PayslipController::servePayslip/$1/$2/$3');

    $routes->get('attendance', 'AttendanceController::getAttendance');
    $routes->get('attendance/summary', 'AttendanceController::getAttendanceSummary');
    $routes->get('employee-id-card', 'EmployeeController::getEmployeeIdCard');
    $routes->get('payslip/status', 'PayslipController::getPayslipStatus');
    $routes->post('payslip/generate', 'PayslipController::generatePayslip');
    $routes->get('employee-profile', 'EmployeeController::getProfileDetails');
    $routes->get('employees/geo-tracking', 'EmployeeController::getGeoTrackingStatus');
    $routes->post('employees/geo-tracking', 'EmployeeController::updateGeoTrackingStatus');
    $routes->get('employees/juniors', 'EmployeeController::getJuniorsEmployees');

    $routes->get('employee/get-status', 'EmployeeController::getEmployeeOnlineStatus');
    $routes->post('employee/update-status', 'EmployeeController::updateEmployeeOnlineStatus');

    $routes->get('get/available/balance', 'RechargeController::checkBalance');
    $routes->post('recharge', 'RechargeController::createRecharge');
    $routes->get('recharge/status', 'RechargeController::checkRechargeStatus');

    $routes->get('recharge/complaint', 'RechargeController::raiseComplaint');
    $routes->get('recharge/callback', 'RechargeController::rechargeCallback');
    $routes->get('recharge/complaint-callback', 'RechargeController::complaintCallback');

    $routes->post('createRequestLetter', 'RequestLetterController::createRequestLetter');
    $routes->get('getRequestLetterHistory', 'RequestLetterController::getRequestLetterHistory');
    $routes->get('employees/details', 'EmployeeController::getEmployeeByCode/$1');
    $routes->get('get-reporting-managers', 'ManagerController::getReportingManagersByCompany');
    // Punch in
    $routes->post('punch-in', 'AttendanceController::punchIn');
    // Punch out
    $routes->post('punch-out', 'AttendanceController::punchOut');
    // Get today's attendance status
    $routes->get('attendance-status', 'AttendanceController::getAttendanceStatus');
});

$routes->post('employees/import-excel', 'EmployeeController::importExcel');
$routes->post('employees/update-status', 'EmployeeController::update_status');
$routes->get('employees/last-updated-history/(:num)', 'EmployeeController::lastUpdatedHistory/$1');


$routes->get('employees/bulk-upload', 'EmployeeController::bulkUpload');
$routes->post('employees/import-preview', 'EmployeeController::importPreview');
$routes->post('employees/save-bulk', 'EmployeeController::saveBulk');
$routes->get('employees/download-format', 'EmployeeController::downloadFormat');
$routes->post('employees/approve/(:num)', 'EmployeeController::approve/$1');


    $routes->get('admin/privileges', 'PrivilegeController::index');
    $routes->get('admin/privileges/create', 'PrivilegeController::create');
    $routes->post('admin/privileges/store', 'PrivilegeController::store');
        // $routes->post('admin/privileges/merchant', 'PrivilegeController::merchantPrivileges');
                $routes->get('admin/privileges/view', 'PrivilegeController::view');

$routes->get('admin/privileges/merchant', 'PrivilegeController::viewMerchantPrivileges');
$routes->post('admin/privileges/merchant/update', 'PrivilegeController::updateMerchantPrivileges');

$routes->post('admin/norka/sendEmails', 'NorkaController::sendEmails');

$routes->post('api/customer/send-otp', 'Api\Auth::customerSendOtp');
$routes->post('api/customer/verify-otp', 'Api\Auth::customerVerifyOtp');

$routes->group('api', ['namespace' => 'App\Controllers\Api'], function ($routes) {
    $routes->get('worldrecharge', 'WorldRecharge::index');
    $routes->post('worldrecharge/get-billers', 'WorldRecharge::getBillers');
    $routes->post('worldrecharge/get-operators', 'WorldRecharge::getOperators');
    $routes->post('worldrecharge/perform-recharge', 'WorldRecharge::performRecharge');
});


// Remittance API Routes

// GetToken - No authentication required
$routes->post('api/v1/Remittance/GetToken', 'Api\RemittanceController::getToken');

// Other Remittance APIs - Require API key and bearer token
$routes->group('api/v1/Remittance', ['namespace' => 'App\Controllers\Api', 'filter' => 'apikey'], function($routes) {
    $routes->post('ValidateUser', 'RemittanceController::validateUser', ['filter' => 'bearerauth']);
    $routes->post('push-request-txn', 'RemittanceController::pushRequestTxn', ['filter' => 'bearerauth']);
    $routes->post('TxnEnquiry', 'RemittanceController::txnEnquiry', ['filter' => 'bearerauth']);
    $routes->post('BalanceEnquiry', 'RemittanceController::balanceEnquiry', ['filter' => 'bearerauth']);
    $routes->post('GetAccountStatement', 'RemittanceController::getAccountStatement', ['filter' => 'bearerauth']);
});

// TAP Payment Webhooks (Uses HMAC signature verification)
$routes->group('api/v1/tap', ['namespace' => 'App\Controllers\Api', 'filter' => 'tapwebhook'], function($routes) {
    $routes->post('deposit-webhook', 'TapWebhookController::receiveDeposit');
    $routes->post('transaction-enquiry', 'TapTransactionEnquiryController::enquiry');
    $routes->post('reconciliation', 'TapTransactionEnquiryController::reconciliation');
});

// Request Validation — verifies the caller is a trusted source via HMAC-SHA256 signature
// Header required: X-Request-Signature: hash_hmac('sha256', raw_body, REQUEST_KEY)
// Body: {"project_id":"DITSL","action":"validate"}
$routes->post('api/v1/validate-request', 'Api\RequestValidationController::validateRequest', ['filter' => 'requestvalidation']);


