# BankCode

Underlying library component's [documentation](https://github.com/czechphp/czech-bank-account#bank-code-component).

This bundle registers BankCode Loader service `czech_bank_account.bank_code_loader`. Which can be overridden to use any Loader implementing `Czechphp\CzechBankAccount\Loader\BankCode\LoaderInterface`.

Default loader is `Czechphp\CzechBankAccount\Loader\BankCode\FilesystemLoader` which uses bundled data with underlying library.

## Basic usage

Override default configuration to load bank codes from custom location.

```yaml
# app/config/services.yml

parameters:
    app_custom_bank_code_filename: '%kernel.cache_dir%/bank_codes.json'

services:
    czech_bank_account.bank_code_loader:
        class: Czechphp\CzechBankAccount\Loader\BankCode\FilesystemLoader
        bind:
            $filename: '%app_custom_bank_code_filename%'
            $converter: null # or service with converter for given file format

```
