<?php

namespace Evotodi\WaveBundle\Service;

use Carbon\Carbon;
use Evotodi\WaveBundle\Dto\Account;
use Evotodi\WaveBundle\Dto\AccountSubType;
use Evotodi\WaveBundle\Dto\AccountType;
use Evotodi\WaveBundle\Dto\Address;
use Evotodi\WaveBundle\Dto\Amount;
use Evotodi\WaveBundle\Dto\Business;
use Evotodi\WaveBundle\Dto\BusinessType;
use Evotodi\WaveBundle\Dto\Country;
use Evotodi\WaveBundle\Dto\Currency;
use Evotodi\WaveBundle\Dto\Customer;
use Evotodi\WaveBundle\Dto\Invoice;
use Evotodi\WaveBundle\Dto\InvoiceItem;
use Evotodi\WaveBundle\Dto\Product;
use Evotodi\WaveBundle\Dto\Province;
use Evotodi\WaveBundle\Dto\ShippingDetails;
use Evotodi\WaveBundle\Dto\Tax;
use Evotodi\WaveBundle\Dto\Taxes;
use Evotodi\WaveBundle\Dto\TaxRate;
use Evotodi\WaveBundle\Dto\User;
use Evotodi\WaveBundle\Dto\Vendor;
use JetBrains\PhpStorm\Pure;

class WaveAppHelper
{
    #[Pure]
    public function buildCurrency(?array $data): Currency
    {
        if(is_null($data)){
            return new Currency(null, null, null, null, null);
        }

        return new Currency(
            $data['code'],
            $data['symbol'],
            $data['name'],
            $data['plural'],
            $data['exponent'],
        );
    }

    #[Pure]
    public function buildProvince(?array $data): Province
    {
        if(is_null($data)){
            return new Province(null, null);
        }
        return new Province($data['code'], $data['name']);
    }

    #[Pure]
    public function buildCountry(?array $data): Country
    {
        if(is_null($data)){
            return new Country(null, null, null, null, null);
        }

        $provinces = [];
        foreach ($data['provinces'] as $province){
            $provinces[$province['code']] = $this->buildProvince($province);
        }

        return new Country(
            $data['code'],
            $data['name'],
            $this->buildCurrency($data['currency']),
            $data['nameWithArticle'],
            $provinces
        );
    }

    #[Pure]
    public function buildBusinessType(?array $data): BusinessType
    {
        if(is_null($data)){
            return new BusinessType(null, null);
        }
        return new BusinessType($data['name'], $data['value']);
    }

    #[Pure]
    public function buildAddress(?array $data): Address
    {
        if(is_null($data)){
            return new Address(null, null, null, null, null, null);
        }
        return new Address(
            $data['addressLine1'],
            $data['addressLine2'],
            $data['city'],
            $this->buildProvince($data['province']),
            $this->buildCountry($data['country']),
            $data['postalCode']
        );
    }

    public function buildBusiness(?array $data): Business
    {
        if(is_null($data)){
            return new Business(null, null, null, null, null, null,
                null, null, null, null, null, null, null, null,
                null, null, null, null, null, );
        }
        return new Business(
            $data['id'],
            $data['name'],
            $data['isPersonal'],
            $data['organizationalType'],
            $this->buildBusinessType($data['type']),
            $this->buildBusinessType($data['subtype']),
            $this->buildCurrency($data['currency']),
            $data['timezone'],
            $this->buildAddress($data['address']),
            $data['phone'],
            $data['fax'],
            $data['mobile'],
            $data['tollFree'],
            $data['website'],
            $data['isClassicAccounting'],
            $data['isClassicInvoicing'],
            $data['isArchived'],
            $data['createdAt'] ? Carbon::parse($data['createdAt'])->toDateTime() : null,
            $data['modifiedAt'] ? Carbon::parse($data['modifiedAt'])->toDateTime(): null,
        );
    }

    public function buildUser(?array $data): User
    {
        if(is_null($data)){
            return new User(null, null, null, null, null, null);
        }

        return new User($data['id'], $data['defaultEmail'], $data['firstName'], $data['lastName'],
            $data['createdAt'] ? Carbon::parse($data['createdAt'])->toDateTime() : null,
            $data['modifiedAt'] ? Carbon::parse($data['modifiedAt'])->toDateTime(): null,
        );
    }

    #[Pure]
    public function buildAccountType(?array $data): AccountType
    {
        if(is_null($data)){
            return new AccountType(null, null, null);
        }

        return new AccountType(
            $data['name'],
            $data['normalBalanceType'],
            $data['value']
        );
    }

    #[Pure]
    public function buildAccountSubType(?array $data): AccountSubType
    {
        if(is_null($data)){
            return new AccountSubType(null, null, null);
        }

        return new AccountSubType(
            $data['name'],
            $data['value'],
            $this->buildAccountType($data['type'])
        );
    }

    #[Pure]
    public function buildShippingDetails(?array $data): ShippingDetails
    {
        if(is_null($data)){
            return new ShippingDetails(null, null, null, null);
        }

        return new ShippingDetails(
            $data['name'],
            $this->buildAddress($data['address']),
            $data['phone'],
            $data['instructions']
        );
    }

    public function buildCustomer(?array $data): Customer
    {
        if(is_null($data)){
            return new Customer(null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null);
        }

        return new Customer(
            $this->buildBusiness($data['business']),
            $data['id'],
            $data['name'],
            $this->buildAddress($data['address']),
            $data['firstName'],
            $data['lastName'],
            $data['displayId'],
            $data['email'],
            $data['mobile'],
            $data['phone'],
            $data['fax'],
            $data['tollFree'],
            $data['website'],
            $data['internalNotes'],
            $this->buildCurrency($data['currency']),
            $this->buildShippingDetails($data['shippingDetails']),
            $data['isArchived'],
            $data['createdAt'] ? Carbon::parse($data['createdAt'])->toDateTime() : null,
            $data['modifiedAt'] ? Carbon::parse($data['modifiedAt'])->toDateTime(): null,
        );
    }

    public function buildProduct(?array $data): Product
    {
        if(is_null($data)){
            return new Product(null, null, null, null, null, null, null, null, null);
        }

        return new Product(
            $data['id'], $data['name'], $data['description'], $data['unitPrice'],
            $data['isSold'], $data['isBought'], $data['isArchived'],
            $data['createdAt'] ? Carbon::parse($data['createdAt'])->toDateTime() : null,
            $data['modifiedAt'] ? Carbon::parse($data['modifiedAt'])->toDateTime(): null,
        );
    }

    public function buildTaxRate(?array $data): TaxRate
    {
        if(is_null($data)){
            return new TaxRate(null, null);
        }

        return new TaxRate(
            $data['effective'] ? Carbon::parse($data['effective'])->toDateTime() : null,
            floatval($data['rate'])
        );
    }

    public function buildTax(?array $data): Tax
    {
        if(is_null($data)){
            return new Tax(null, null, null, null, null, null, null, null, null, null, null, null, null, null);
        }
        $rates = [];
        foreach ($data['rates'] as $rate){
            $rates[] = $this->buildTaxRate($rate);
        }
        return new Tax(
            $this->buildBusiness($data['business']),
            $data['id'],
            $data['name'],
            $data['abbreviation'],
            $data['description'],
            $data['taxNumber'],
            $data['showTaxNumberOnInvoices'],
            floatval($data['rate']),
            $rates,
            $data['isCompound'],
            $data['isRecoverable'],
            $data['isArchived'],
            $data['createdAt'] ? Carbon::parse($data['createdAt'])->toDateTime() : null,
            $data['modifiedAt'] ? Carbon::parse($data['modifiedAt'])->toDateTime(): null,
        );
    }

    #[Pure]
    public function buildAmount(?array $data): Amount
    {
        if(is_null($data)){
            return new Amount(null, null, null);
        }

        return new Amount($data['raw'], $data['value'], $this->buildCurrency($data['currency']));
    }

    public function buildAccount(?array $data): Account
    {
        if(is_null($data)){
            return new Account(null, null, null, null, null, null, null, null, null, null, null, null, null);
        }

        return new Account(
            $this->buildBusiness($data['business']),
            $data['id'],
            $data['name'],
            $data['description'],
            $data['displayId'],
            $this->buildCurrency($data['currency']),
            $this->buildAccountType($data['type']),
            $this->buildAccountSubType($data['subtype']),
            $data['normalBalanceType'],
            $data['isArchived'],
            $data['sequence'],
            $data['balance'],
            $data['balanceInBusinessCurrency']
        );
    }

    public function buildTaxes(?array $data): Taxes
    {
        if(is_null($data)){
            return new Taxes(null, null, null);
        }

        return new Taxes(
            $this->buildAmount($data['amount']),
            floatval($data['rate']),
            $this->buildTax($data['salesTax']),
        );
    }

    public function buildInvoiceItem(?array $data): InvoiceItem
    {
        if(is_null($data)){
            return new InvoiceItem(null, null, null, null, null, null, null, null);
        }

        $taxes = [];
        foreach ($data['taxes'] as $tax){
            $taxes[] = $this->buildTaxes($tax);
        }

        return new InvoiceItem(
            $this->buildAccount($data['account']),
            $data['description'],
            floatval($data['quantity']),
            floatval($data['unitPrice']),
            $this->buildAmount($data['subtotal']),
            $this->buildAmount($data['total']),
            $taxes,
            $this->buildProduct($data['product'])
        );
    }

    public function buildInvoice(?array $data): Invoice
    {
        if(is_null($data)){
            return new Invoice(null, null, null, null, null, null, null, null, null, null, null,
                null,  null, null, null, null,  null, null, null, null,  null, null,
                null, null,  null, null, null, null,  null, null, null, null,  null, null, null, null,  null);
        }

        $items = [];
        foreach ($data['items'] as $item){
            $items[] = $this->buildInvoiceItem($item);
        }

        return new Invoice(
            $this->buildBusiness($data['business']),
            $this->buildCustomer($data['customer']),
            $data['id'],
            $data['source'],
            $data['pdfUrl'],
            $data['viewUrl'],
            $data['status'],
            $data['title'],
            $data['subhead'],
            $data['invoiceNumber'],
            $data['poNumber'],
            $data['invoiceDate'] ? Carbon::parse($data['invoiceDate'])->toDateTime() : null,
            $data['dueDate'] ? Carbon::parse($data['dueDate'])->toDateTime() : null,
            $this->buildAmount($data['amountDue']),
            $this->buildAmount($data['amountPaid']),
            $this->buildAmount($data['taxTotal']),
            $this->buildAmount($data['total']),
            $this->buildCurrency($data['currency']),
            floatval($data['exchangeRate']),
            $items,
            $data['memo'],
            $data['footer'],
            $data['disableCreditCardPayments'],
            $data['disableBankPayments'],
            $data['disableAmexPayments'],
            $data['itemTitle'],
            $data['unitTitle'],
            $data['priceTitle'],
            $data['amountTitle'],
            $data['hideName'],
            $data['hideDescription'],
            $data['hideUnit'],
            $data['hidePrice'],
            $data['hideAmount'],
            $data['lastSentAt'] ? Carbon::parse($data['lastSentAt'])->toDateTime() : null,
            $data['lastSentVia'],
            $data['lastViewedAt'] ? Carbon::parse($data['lastViewedAt'])->toDateTime() : null,
        );
    }

    public function buildVendor(?array $data): Vendor
    {
        if(is_null($data)){
            return new Vendor(null, null, null, null, null, null, null, null, null, null, null,
                null,  null, null, null, null,  null);
        }

        return new Vendor(
            $data['id'],
            $data['name'],
            $this->buildAddress($data['address']),
            $data['firstName'],
            $data['lastName'],
            $data['displayId'],
            $data['email'],
            $data['mobile'],
            $data['phone'],
            $data['fax'],
            $data['tollFree'],
            $data['website'],
            $data['internalNotes'],
            $this->buildCurrency($data['currency']),
            $data['isArchived'],
            $data['createdAt'] ? Carbon::parse($data['createdAt'])->toDateTime() : null,
            $data['modifiedAt'] ? Carbon::parse($data['modifiedAt'])->toDateTime(): null,
        );
    }
}
