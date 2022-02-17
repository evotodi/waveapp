<?php

namespace Evotodi\WaveBundle\GraphQL;

class QueryObject
{
    public static function OAuthApplication(): string
    {
        return <<<GQL
id
name
description
clientId
logoUrl
extraData
createdAt
modifiedAt
GQL;
    }

    public static function user(): string
    {
        return <<<GQL
id
defaultEmail
firstName
lastName
createdAt
modifiedAt
GQL;
    }

    public static function invoice(): string
    {
        $business = self::business();
        $customer = self::customer();
        $money = self::money();
        $currency = self::currency();
        $invoiceItem = self::invoiceItems();

        return <<<GQL
business {
    $business
}
customer {
    $customer
}
id
createdAt
modifiedAt
source {
    __typename
}
pdfUrl
viewUrl
status
title
subhead
invoiceNumber
poNumber
invoiceDate
dueDate
amountDue {
    $money
}
amountPaid {
    $money
}
taxTotal {
    $money
}
total {
    $money
}
currency {
    $currency
}
exchangeRate
items {
    $invoiceItem
}
memo
footer
disableCreditCardPayments
disableBankPayments
disableAmexPayments
itemTitle
unitTitle
priceTitle
amountTitle
hideName
hideDescription
hideUnit
hidePrice
hideAmount
lastSentAt
lastSentVia
lastViewedAt
GQL;
    }

    public static function business(): string
    {
        $businessType = self::businessType();
        $businessSubType = self::businessSubType();
        $currency = self::currency();
        $address = self::address();

        return <<<GQL
id 
name 
isPersonal 
organizationalType 
type {
    $businessType
}
subtype {
    $businessSubType
} 
currency { 
    $currency 
}
timezone 
address {
    $address
} 
phone 
fax 
mobile 
tollFree 
website 
isClassicAccounting 
isClassicInvoicing 
isArchived 
createdAt 
modifiedAt
GQL;
    }

    public static function businessType(): string
    {
        return <<<GQL
name
value
GQL;
    }

    public static function businessSubType(): string
    {
        return <<<GQL
name
value
GQL;
    }

    public static function currency(): string
    {
        return <<<GQL
code 
symbol 
name 
plural 
exponent 
GQL;
    }

    public static function address(): string
    {
        $province = self::province();
        $country = self::country();

        return <<<GQL
addressLine1 
addressLine2 
city 
province {
    $province
}
country {
    $country
} 
postalCode 
GQL;
    }

    public static function province(): string
    {
        return <<<GQL
code 
name 
GQL;
    }

    public static function country(): string
    {
        $currency = self::currency();
        $province = self::province();

        return <<<GQL
code
name
currency {
    $currency
}
nameWithArticle
provinces {
    $province
}
GQL;
    }

    public static function customer(): string
    {
        $business = self::business();
        $address = self::address();
        $currency = self::currency();
        $shippingDetails = self::shippingDetails();

        return <<<GQL
business {
    $business
}
id
name
address {
    $address
}
firstName
lastName
displayId
email
mobile
phone
fax
tollFree
website
internalNotes
currency {
    $currency
}
shippingDetails {
    $shippingDetails
}
createdAt
modifiedAt
isArchived
GQL;
    }

    public static function shippingDetails(): string
    {
        $address = self::address();

        return <<<GQL
name
address {
    $address
}
phone
instructions
GQL;
    }

    public static function money(): string
    {
        $currency = self::currency();

        return <<<GQL
raw
value
currency {
    $currency
}
GQL;
    }

    public static function invoiceItems(): string
    {
        $account = self::account();
        $money = self::money();
        $taxes = self::invoiceItemTax();
        $product = self::product();

        return <<<GQL
account {
    $account
}
description
quantity
unitPrice
subtotal {
    $money
}
total {
    $money
}
taxes {
    $taxes
}
product {
    $product
}
GQL;
    }

    public static function account(): string
    {
        $business = self::business();
        $currency = self::currency();
        $accountType = self::accountType();
        $accountSubtype = self::accountSubtype();

        return <<<GQL
business {
    $business
}
id
name
description
displayId
currency {
    $currency
}
type {
    $accountType
}
subtype {
    $accountSubtype
}
normalBalanceType
isArchived
sequence
balance
balanceInBusinessCurrency
GQL;
    }

    public static function accountType(): string
    {
        return <<<GQL
name 
normalBalanceType 
value 
GQL;
    }

    public static function accountSubtype(): string
    {
        $accountType = self::accountType();

        return <<<GQL
name 
value 
type {
    $accountType
} 
GQL;
    }

    public static function invoiceItemTax(): string
    {
        $money = self::money();
        $salesTax = self::salesTax();

        return <<<GQL
amount {
    $money
}
rate
salesTax {
    $salesTax
}
GQL;
    }

    public static function salesTax(): string
    {
        $business = self::business();
        $salesTaxRate = self::salesTaxRate();

        return <<<GQL
business {
    $business
}
id
name
abbreviation
description
taxNumber
showTaxNumberOnInvoices
rate
rates {
    $salesTaxRate
}
isCompound
isRecoverable
isArchived
createdAt
modifiedAt
GQL;
    }

    public static function salesTaxRate(): string
    {
        return <<<GQL
effective
rate
GQL;
    }

    public static function product(): string
    {
        return <<<GQL
id 
name 
description 
unitPrice 
isSold 
isBought 
isArchived 
createdAt
modifiedAt
GQL;
    }

    public static function transaction(): string
    {
        return <<<GQL
id
GQL;
    }

    public static function vendor(): string
    {
        //removed:
        //business {
        //    $business
        //}

        //$business = self::business();
        $address = self::address();
        $currency = self::currency();
        $shippingDetails = self::shippingDetails();

        return <<<GQL

id
name
address {
    $address
}
firstName
lastName
displayId
email
mobile
phone
fax
tollFree
website
internalNotes
currency {
    $currency
}
shippingDetails {
    $shippingDetails
}
createdAt
modifiedAt
isArchived
GQL;
    }
}
