<?php /** @noinspection PhpUnused */

namespace Evotodi\WaveBundle\Service;

use DateTime;
use Evotodi\WaveBundle\Builder\ResponseBuilder;
use Evotodi\WaveBundle\Dto\Account;
use Evotodi\WaveBundle\Dto\AccountSubType;
use Evotodi\WaveBundle\Dto\AccountType;
use Evotodi\WaveBundle\Dto\Business;
use Evotodi\WaveBundle\Dto\Country;
use Evotodi\WaveBundle\Dto\Currency;
use Evotodi\WaveBundle\Dto\Customer;
use Evotodi\WaveBundle\Dto\Invoice;
use Evotodi\WaveBundle\Dto\Product;
use Evotodi\WaveBundle\Dto\Province;
use Evotodi\WaveBundle\Dto\Tax;
use Evotodi\WaveBundle\Dto\TaxRate;
use Evotodi\WaveBundle\Dto\User;
use Evotodi\WaveBundle\Dto\Vendor;
use Evotodi\WaveBundle\Exceptions\ResponseException;
use Evotodi\WaveBundle\GraphQL\Mutation;
use Evotodi\WaveBundle\GraphQL\Query;
use Evotodi\WaveBundle\Model\QueryModel;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use InvalidArgumentException;

class WaveApp
{
    protected Client $client;
    protected array $headers;
    protected string $url;
    protected string $token;
    protected string $businessId;
    protected ResponseBuilder $responseBuilder;
    private WaveAppHelper $appHelper;

    public function __construct(WaveAppHelper $appHelper)
    {
        $this->token = $_ENV['WAVEAPPS_ACCESS_TOKEN'];
        if (empty($this->token)) {
            throw new InvalidArgumentException("Please provide wave app's token in env", 400);
        }

        $this->url = $_ENV['WAVEAPPS_GRAPHQL_URI'];
        if (empty($this->url)) {
            throw new InvalidArgumentException("Please provide wave app's graphql uri in env", 400);
        }

        $this->businessId = $_ENV['WAVEAPPS_BUSINESS_ID'];
        if (empty($this->businessId)) {
            throw new InvalidArgumentException("Please provide wave app's business_id in env", 400);
        }

        $this->client = new Client();
        $this->headers = [
            'Authorization' => 'Bearer '.$this->token,
        ];
        $this->responseBuilder = new ResponseBuilder();
        $this->appHelper = $appHelper;
    }

    public function getHelper(): WaveAppHelper
    {
        return $this->appHelper;
    }

    private function buildQuery(string $method, ?array $params = null): QueryModel
    {
        return new QueryModel(Query::$method(), $params, null);
    }

    private function buildMutation(string $method, string $operationName, array $params): QueryModel
    {
        return new QueryModel(Mutation::$method(), $params, $operationName);
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    private function doRequest(QueryModel $queryModel): array
    {
        $options = [
            'json' => [
                'query' => $queryModel->query,
                'variables' => $queryModel->variables,
                'operationName' => $queryModel->operationName,

            ],
            'headers' => $this->headers,
        ];

        try {
            $response = $this->client->post($this->url, $options);

            return $this->responseBuilder->success($response);
        } catch (Exception $e) {
            $this->responseBuilder->errors($e);
        }
    }

    private function checkResponse(array $response, string $method): bool|array
    {
        if(key_exists('inputErrors', $response['data'][$method])){
            if(!is_null($response['data'][$method]['inputErrors'])){
                return false;
            }
        }
        if(key_exists('didSucceed', $response['data'][$method])){
            return $response;
        }

        return false;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getCurrency(string $currencyCode): Currency
    {
        $query = $this->buildQuery('currency', ['code' => strtoupper($currencyCode)]);
        $resp = $this->doRequest($query);
        return $this->appHelper->buildCurrency($resp['data']['currency']);
    }

    /**
     * @return Currency[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getCurrencies(): array
    {
        $query = $this->buildQuery('currencies');
        $resp = $this->doRequest($query);
        $currencies = [];
        foreach ($resp['data']['currencies'] as $currency){
            $currencies[$currency['code']] = $this->appHelper->buildCurrency($currency);
        }
        return $currencies;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getCountry(string $countryCode): Country
    {
        $query = $this->buildQuery('country', ['code' => strtoupper($countryCode)]);
        $resp = $this->doRequest($query);

        return $this->appHelper->buildCountry($resp['data']['country']);
    }

    /**
     * @return Country[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getCountries(): array
    {
        $query = $this->buildQuery('countries');
        $resp = $this->doRequest($query);
        $countries = [];
        foreach ($resp['data']['countries'] as $country){
            $countries[$country['code']] = $this->appHelper->buildCountry($country);
        }
        return $countries;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getProvince(string $provinceCode): Province
    {
        $query = $this->buildQuery('province', ['code' => strtoupper($provinceCode)]);
        $resp = $this->doRequest($query);

        return $this->appHelper->buildProvince($resp['data']['province']);
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusiness(?string $businessId = null): Business
    {
        $query = $this->buildQuery('business', ['id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID']]);
        $resp = $this->doRequest($query);
        return $this->appHelper->buildBusiness($resp['data']['business']);
    }

    /**
     * @return Business[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinesses(int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('businesses', ['page' => $page, 'pageSize' => $items]);
        $resp = $this->doRequest($query);

        $businesses = [];
        foreach ($resp['data']['businesses']['edges'] as $businessNode){
            $businesses[] = $this->appHelper->buildBusiness($businessNode['node']);
        }
        return $businesses;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getUser(): User
    {
        $query = $this->buildQuery('user');
        $resp = $this->doRequest($query);

        return $this->appHelper->buildUser($resp['data']['user']);
    }

    /**
     * @return AccountType[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getAccountTypes(): array
    {
        $query = $this->buildQuery('accountTypes');
        $resp = $this->doRequest($query);
        $accountTypes = [];
        foreach ($resp['data']['accountTypes'] as $accountType){
            $accountTypes[$accountType['name']] = $this->appHelper->buildAccountType($accountType);
        }
        return $accountTypes;
    }

    /**
     * @return AccountSubType[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getAccountSubTypes(): array
    {
        $query = $this->buildQuery('accountSubtypes');
        $resp = $this->doRequest($query);
        $accountSubTypes = [];
        foreach ($resp['data']['accountSubtypes'] as $accountSubType){
            $accountSubTypes[$accountSubType['name']] = $this->appHelper->buildAccountSubType($accountSubType);
        }
        return $accountSubTypes;
    }

    /**
     * @return Customer[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getCustomers(?string $businessId = null, int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('customers', ['businessId' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'], 'page' => $page, 'pageSize' => $items]);
        $resp = $this->doRequest($query);
        $customers = [];
        foreach ($resp['data']['business']['customers']['edges'] as $customer){
            $customers[$customer['node']['id']] = $this->appHelper->buildCustomer($customer['node']);
        }
        return $customers;
    }

    /**
     * @throws GuzzleException
     */
    public function customerExists(string $customerId, ?string $businessId = null): Customer|false
    {
        $query = $this->buildQuery('customerExists', ['businessId' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'], 'customerId' => $customerId]);
        try {
            $resp = $this->doRequest($query);
        }catch (ResponseException){
            return false;
        }

        return $this->appHelper->buildCustomer($resp['data']['business']['customer']);
    }

    /**
     * @return Product[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getProducts(?string $businessId = null): array
    {
        $query = $this->buildQuery('products', ['businessId' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID']]);
        $resp = $this->doRequest($query);

        $products = [];
        foreach ($resp['data']['business']['products']['edges'] as $product){
            $products[$product['node']['id']] = $this->appHelper->buildProduct($product['node']);
        }
        return $products;
    }

    /**
     * @return Tax[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getTaxes(?string $businessId = null): array
    {
        $query = $this->buildQuery('taxes', ['businessId' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID']]);
        $resp = $this->doRequest($query);

        $businesses = [];
        foreach ($resp['data']['business']['salesTaxes']['edges'] as $business){
            $businesses[$business['node']['id']] = $this->appHelper->buildTax($business['node']);
        }

        return $businesses;
    }

    /**
     * @return Invoice[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function invoicesByCustomerByStatus(string $customerId, string $invoiceStatus, ?string $businessId = null, int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('invoicesByCustomerByStatus', [
                'businessId' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'customerId' => $customerId,
                'invoiceStatus' => $invoiceStatus,
                'page' => $page,
                'pageSize' => $items
            ]
        );
        $resp = $this->doRequest($query);

        $invoices = [];
        foreach ($resp['data']['business']['invoices']['edges'] as $invoice){
            $invoices[$invoice['node']['id']] = $this->appHelper->buildInvoice($invoice['node']);
        }

        return $invoices;
    }

    /**
     * @return Account[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getAccounts(?string $businessId = null, int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('businessAccounts', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'account_page' => $page,
                'account_page_size' => $items
            ]
        );
        $resp = $this->doRequest($query);

        $accounts = [];
        foreach ($resp['data']['business']['accounts']['edges'] as $account){
            $accounts[$account['node']['id']] = $this->appHelper->buildAccount($account['node']);
        }

        return $accounts;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessAccount(string $accountId, ?string $businessId = null): Account
    {
        $query = $this->buildQuery('getBusinessAccount', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'account_id' => $accountId
            ]
        );
        $resp = $this->doRequest($query);

        return $this->appHelper->buildAccount($resp['data']['business']['account']);
    }

    /**
     * @return Customer[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessCustomers(?string $businessId = null, int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('businessCustomers', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'customer_page' => $page,
                'customer_page_size' => $items
            ]
        );
        $resp = $this->doRequest($query);

        $customers = [];
        foreach ($resp['data']['business']['customers']['edges'] as $customer){
            $customers[$customer['node']['id']] = $this->appHelper->buildCustomer($customer['node']);
        }

        return $customers;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessCustomer(string $customerId, ?string $businessId = null): Customer
    {
        $query = $this->buildQuery('getBusinessCustomer', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'customer_id' => $customerId
            ]
        );
        $resp = $this->doRequest($query);

        return $this->appHelper->buildCustomer($resp['data']['business']['customer']);
    }

    /**
     * @return Invoice[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessInvoices(?string $businessId = null, int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('businessInvoices', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'invoice_page' => $page,
                'invoice_page_size' => $items
            ]
        );
        $resp = $this->doRequest($query);

        $invoices = [];
        foreach ($resp['data']['business']['invoices']['edges'] as $invoice){
            $invoices[$invoice['node']['id']] = $this->appHelper->buildInvoice($invoice['node']);
        }

        return $invoices;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessInvoice(string $invoiceId, ?string $businessId = null): Invoice
    {
        $query = $this->buildQuery('getBusinessInvoices', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'invoice_id' => $invoiceId
            ]
        );
        $resp = $this->doRequest($query);

        return $this->appHelper->buildInvoice($resp['data']['business']['invoice']);
    }

    /**
     * @return Tax[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessSalesTaxes(?string $businessId = null, int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('businessSalesTaxes', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'tax_page' => $page, 'tax_page_size' => $items
            ]
        );
        $resp = $this->doRequest($query);

        $taxes = [];
        foreach ($resp['data']['business']['salesTaxes']['edges'] as $tax){
            $taxes[$tax['node']['id']] = $this->appHelper->buildTax($tax['node']);
        }

        return $taxes;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessSalesTax(string $taxId, ?string $businessId = null): Tax
    {
        $query = $this->buildQuery('getBusinessSalesTax', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'tax_id' => $taxId
            ]
        );
        $resp = $this->doRequest($query);

        return $this->appHelper->buildTax($resp['data']['business']['salesTax']);
    }

    /**
     * @return Product[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessProducts(?string $businessId = null, int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('businessProducts', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'product_page' => $page, 'product_page_size' => $items
            ]
        );
        $resp = $this->doRequest($query);

        $products = [];
        foreach ($resp['data']['business']['products']['edges'] as $product){
            $products[$product['node']['id']] = $this->appHelper->buildProduct($product['node']);
        }

        return $products;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessProduct(string $productId, ?string $businessId = null): Product
    {
        $query = $this->buildQuery('getBusinessProduct', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'product_id' => $productId
            ]
        );
        $resp = $this->doRequest($query);

        return $this->appHelper->buildProduct($resp['data']['business']['product']);
    }

    /**
     * @return Vendor[]
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessVendors(?string $businessId = null, int $page = 1, int $items = 10): array
    {
        $query = $this->buildQuery('businessVendors', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'vendor_page' => $page, 'vendor_page_size' => $items
            ]
        );
        $resp = $this->doRequest($query);

        $vendors = [];
        foreach ($resp['data']['business']['vendors']['edges'] as $vendor){
            $vendors[$vendor['node']['id']] = $this->appHelper->buildVendor($vendor['node']);
        }

        return $vendors;
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function getBusinessVendor(string $vendorId, ?string $businessId = null): Vendor
    {
        $query = $this->buildQuery('getBusinessVendor', [
                'business_id' => $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'],
                'vendor_id' => $vendorId
            ]
        );
        $resp = $this->doRequest($query);

        return $this->appHelper->buildVendor($resp['data']['business']['vendor']);
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function customerCreate(Customer $customer): bool|array
    {
        $query = $this->buildMutation(
            'customerCreate',
            'CustomerCreateInput',
            ['input' => $customer->toCreateArray()]
        );
        $resp = $this->doRequest($query);

        return $this->checkResponse($resp, 'customerCreate');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function customerPatch(Customer $customer): bool|array
    {
        $query = $this->buildMutation(
            'customerPatch',
            'CustomerPatchInput',
            ['input' => $customer->toPatchArray()]
        );
        $resp = $this->doRequest($query);

        return $this->checkResponse($resp, 'customerPatch');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function customerDelete(Customer $customer): bool|array
    {
        $query = $this->buildMutation(
            'customerDelete',
            'CustomerDeleteInput',
            ['input' => $customer->toDeleteArray()]
        );
        $resp = $this->doRequest($query);

        return $this->checkResponse($resp, 'customerDelete');
    }

    //todo-evo: These cause an unknown error
    ///**
    // * @throws GuzzleException
    // * @throws ResponseException
    // */
    //public function accountCreate(Account $account): bool
    //{
    //    $query = $this->buildMutation(
    //        'accountCreate',
    //        'AccountCreateInput',
    //        ['input' => $account->toCreateArray()]
    //    );
    //    dump($query);
    //    $resp = $this->doRequest($query);
    //
    //    return $this->checkResponse($resp, 'accountCreate');
    //}
    //
    ///**
    // * @throws GuzzleException
    // * @throws ResponseException
    // */
    //public function accountPatch(Account $account): bool
    //{
    //    $query = $this->buildMutation(
    //        'accountPatch',
    //        'AccountPatchInput',
    //        ['input' => $account->toPatchArray()]
    //    );
    //    $resp = $this->doRequest($query);
    //
    //    return $this->checkResponse($resp, 'accountPatch');
    //}
    //
    ///**
    // * @throws GuzzleException
    // * @throws ResponseException
    // */
    //public function accountArchive(Account $account): bool
    //{
    //    $query = $this->buildMutation(
    //        'accountArchive',
    //        'AccountArchiveInput',
    //        ['input' => $account->toArchiveArray()]
    //    );
    //    $resp = $this->doRequest($query);
    //
    //    return $this->checkResponse($resp, 'accountArchive');
    //}

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function productCreate(Product $product, ?string $incomeAccountId, ?string $expenseAccountId, ?string $businessId = null, ?array $defaultSalesTaxIds = []): bool|array
    {
        $params = ['input' => $product->toCreateArray()];
        $params['input']['businessId'] = $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'];
        $params['input']['incomeAccountId'] = $incomeAccountId;
        $params['input']['expenseAccountId'] = $expenseAccountId;
        $params['input']['defaultSalesTaxIds'] = $defaultSalesTaxIds;

        $query = $this->buildMutation(
            'productCreate',
            'ProductCreateInput',
            $params
        );
        $resp = $this->doRequest($query);

        return $this->checkResponse($resp, 'productCreate');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function productPatch(Product $product, ?string $incomeAccountId, ?string $expenseAccountId, ?array $defaultSalesTaxIds = []): bool|array
    {
        $params = ['input' => $product->toPatchArray()];
        $params['input']['incomeAccountId'] = $incomeAccountId;
        $params['input']['expenseAccountId'] = $expenseAccountId;
        $params['input']['defaultSalesTaxIds'] = $defaultSalesTaxIds;

        $query = $this->buildMutation(
            'productPatch',
            'ProductPatchInput',
            $params
        );
        $resp = $this->doRequest($query);

        return $this->checkResponse($resp, 'productPatch');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function productArchive(Product $product): bool|array
    {
        $query = $this->buildMutation(
            'productArchive',
            'ProductArchiveInput',
            ['input' => $product->toArchiveArray()]
        );
        $resp = $this->doRequest($query);

        return $this->checkResponse($resp, 'productArchive');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function salesTaxCreate(Tax $tax): bool|array
    {
        $params = ['input' => $tax->toCreateArray()];
        $params['input']['businessId'] = $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'];

        $query = $this->buildMutation(
            'salesTaxCreate',
            'SalesTaxCreateInput',
            $params
        );
        $resp = $this->doRequest($query);
        return $this->checkResponse($resp, 'salesTaxCreate');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function salesTaxPatch(Tax $tax): bool|array
    {
        $query = $this->buildMutation(
            'salesTaxPatch',
            'SalesTaxPatchInput',
            ['input' => $tax->toPatchArray()]
        );
        $resp = $this->doRequest($query);

        return $this->checkResponse($resp, 'salesTaxPatch');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function salesTaxArchive(Tax $tax): bool|array
    {
        $query = $this->buildMutation(
            'salesTaxArchive',
            'SalesTaxArchiveInput',
            ['input' => $tax->toArchiveArray()]
        );
        $resp = $this->doRequest($query);

        return $this->checkResponse($resp, 'salesTaxArchive');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function salesTaxRateCreate(TaxRate $taxRate, string $taxId): bool|array
    {
        $params = ['input' => $taxRate->toCreateArray()];
        $params['input']['id'] = $taxId;

        $query = $this->buildMutation(
            'salesTaxRateCreate',
            'SalesTaxRateCreateInput',
            $params
        );
        $resp = $this->doRequest($query);
        return $this->checkResponse($resp, 'salesTaxRateCreate');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function invoiceCreate(Invoice $invoice): bool|array
    {
        $params = ['input' => $invoice->toCreateArray()];
        $params['input']['businessId'] = $businessId ?? $_ENV['WAVEAPPS_BUSINESS_ID'];

        $query = $this->buildMutation(
            'invoiceCreate',
            'InvoiceCreateInput',
            $params
        );
        $resp = $this->doRequest($query);
        return $this->checkResponse($resp, 'invoiceCreate');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function invoiceClone(Invoice $invoice): bool|array
    {
        $query = $this->buildMutation(
            'invoiceClone',
            'InvoiceCloneInput',
            ['input' => $invoice->toCloneArray()]
        );
        $resp = $this->doRequest($query);
        return $this->checkResponse($resp, 'invoiceClone');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function invoiceDelete(Invoice $invoice): bool|array
    {
        $query = $this->buildMutation(
            'invoiceDelete',
            'InvoiceDeleteInput',
            ['input' => $invoice->toDeleteArray()]
        );
        $resp = $this->doRequest($query);
        return $this->checkResponse($resp, 'invoiceDelete');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function invoiceApprove(Invoice $invoice): bool|array
    {
        $query = $this->buildMutation(
            'invoiceApprove',
            'InvoiceApproveInput',
            ['input' => $invoice->toInvoiceApproveArray()]
        );
        $resp = $this->doRequest($query);
        return $this->checkResponse($resp, 'invoiceApprove');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function invoiceSend(Invoice $invoice, string $to, string $subject, string $message, bool $attachPdf, string $fromAddress, bool $ccMyself): bool|array
    {
        $params = ['input' => $invoice->toInvoiceSendArray()];
        $params['input']['to'] = $to;
        $params['input']['subject'] = $subject;
        $params['input']['message'] = $message;
        $params['input']['attachPdf'] = $attachPdf;
        $params['input']['fromAddress'] = $fromAddress;
        $params['input']['ccMyself'] = $ccMyself;


        $query = $this->buildMutation(
            'invoiceSend',
            'InvoiceSendInput',
            $params
        );
        $resp = $this->doRequest($query);
        return $this->checkResponse($resp, 'invoiceSend');
    }

    /**
     * @throws GuzzleException
     * @throws ResponseException
     */
    public function invoiceMarkSent(Invoice $invoice, string $sendMethod, DateTime $sentAt): bool|array
    {
        $params = ['input' => $invoice->toInvoiceMarkSentArray()];
        $params['input']['sendMethod'] = $sendMethod;
        $params['input']['sentAt'] = $sentAt;

        $query = $this->buildMutation(
            'invoiceMarkSent',
            'InvoiceMarkSentInput',
            $params
        );
        $resp = $this->doRequest($query);
        return $this->checkResponse($resp, 'invoiceMarkSent');
    }
}
