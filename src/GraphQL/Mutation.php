<?php /** @noinspection PhpUnused */

namespace Evotodi\WaveBundle\GraphQL;

class Mutation
{
    public static function customerCreate(): string
    {
        $customer = QueryObject::customer();

        return <<<GQL
mutation CustomerCreateInput(\$input: CustomerCreateInput!) { 
    customerCreate(input: \$input) { 
        customer {
            $customer
        }
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function customerPatch(): string
    {
        $customer = QueryObject::customer();

        return <<<GQL
mutation CustomerPatchInput(\$input: CustomerPatchInput!) { 
    customerPatch(input: \$input) { 
        customer {
            $customer
        }
        didSucceed 
        inputErrors { 
            message 
            path 
            code 
        } 
    } 
}
GQL;
    }

    public static function customerDelete(): string
    {
        return <<<GQL
mutation CustomerDeleteInput(\$input: CustomerDeleteInput!) { 
    customerDelete(input: \$input) { 
        didSucceed 
        inputErrors { 
            message 
            path 
            code 
        } 
    } 
}
GQL;
    }

    public static function accountCreate(): string
    {
        $account = QueryObject::account();

        return <<<GQL
mutation AccountCreateInput(\$input: AccountCreateInput!) { 
    accountCreate(input: \$input) { 
        account {
            $account
        } 
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function accountPatch(): string
    {
        $account = QueryObject::account();

        return <<<GQL
mutation AccountPatchInput(\$input: AccountPatchInput!) { 
    accountPatch(input: \$input) { 
        account {
            $account
        } 
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function accountArchive(): string
    {
        return <<<GQL
mutation AccountArchiveInput(\$input: AccountArchiveInput!) { 
    accountArchive(input: \$input) { 
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function productCreate(): string
    {
        $product = QueryObject::product();

        return <<<GQL
mutation ProductCreateInput(\$input: ProductCreateInput!) { 
    productCreate(input: \$input) { 
        product {
            $product
        }
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function productPatch(): string
    {
        $product = QueryObject::product();

        return <<<GQL
mutation ProductPatchInput(\$input: ProductPatchInput!) { 
    productPatch(input: \$input) { 
        product {
            $product
        } 
        didSucceed 
        inputErrors { 
            message 
            path 
            code 
        } 
    } 
}
GQL;
    }

    public static function productArchive(): string
    {
        $product = QueryObject::product();

        return <<<GQL
mutation ProductArchiveInput(\$input: ProductArchiveInput!) { 
    productArchive(input: \$input) { 
        product {
            $product
        }
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function salesTaxCreate(): string
    {
        $salesTax = QueryObject::salesTax();

        return <<<GQL
mutation SalesTaxCreateInput(\$input: SalesTaxCreateInput!) { 
    salesTaxCreate(input: \$input) { 
        salesTax {
            $salesTax
        }
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function salesTaxPatch(): string
    {
        $salesTax = QueryObject::salesTax();

        return <<<GQL
mutation SalesTaxPatchInput(\$input: SalesTaxPatchInput!) { 
    salesTaxPatch(input: \$input) { 
        salesTax {
            $salesTax
        } 
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function salesTaxArchive(): string
    {
        $salesTax = QueryObject::salesTax();

        return <<<GQL
mutation SalesTaxArchiveInput(\$input: SalesTaxArchiveInput!) { 
    salesTaxArchive(input: \$input) { 
        salesTax {
            $salesTax
        }
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function salesTaxRateCreate(): string
    {
        return <<<GQL
mutation SalesTaxRateCreateInput(\$input: SalesTaxRateCreateInput!) { 
    salesTaxRateCreate(input: \$input) { 
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function moneyTransactionCreate(): string
    {
        $transaction = QueryObject::transaction();

        return <<<GQL
mutation MoneyTransactionCreateInput(\$input: MoneyTransactionCreateInput!) { 
    moneyTransactionCreate(input: \$input) { 
        transaction $transaction
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function invoiceCreate(): string
    {
        $invoice = QueryObject::invoice();

        return <<<GQL
mutation InvoiceCreateInput(\$input: InvoiceCreateInput!) { 
    invoiceCreate(input: \$input) { 
        invoice {
            $invoice
        }
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function invoiceClone(): string
    {
        $invoice = QueryObject::invoice();

        return <<<GQL
mutation InvoiceCloneInput(\$input: InvoiceCloneInput!) {
    invoiceClone(input: \$input) {
        invoice {
            $invoice
        }
        didSucceed
        inputErrors {
            path 
            message 
            code
        }
    }
}
GQL;
    }

    public static function invoiceDelete(): string
    {
        return <<<GQL
mutation InvoiceDeleteInput(\$input: InvoiceDeleteInput!) { 
    invoiceDelete(input: \$input) { 
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function invoiceSend(): string
    {
        return <<<GQL
mutation InvoiceSendInput(\$input: InvoiceSendInput!) { 
    invoiceSend(input: \$input) { 
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function invoiceApprove(): string
    {
        $invoice = QueryObject::invoice();

        return <<<GQL
mutation InvoiceApproveInput(\$input: InvoiceApproveInput!) { 
    invoiceApprove(input: \$input) { 
        invoice {
            $invoice
        }
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }

    public static function invoiceMarkSent(): string
    {
        $invoice = QueryObject::invoice();

        return <<<GQL
mutation InvoiceMarkSentInput(\$input: InvoiceMarkSentInput!) { 
    invoiceMarkSent(input: \$input) { 
        invoice {
            $invoice
        }
        didSucceed 
        inputErrors { 
            path 
            message 
            code 
        } 
    } 
}
GQL;
    }
}
