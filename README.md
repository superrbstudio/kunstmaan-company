# SuperrbKunstmaanCompanyBundle

## Installation

### Step 1: Install the Bundle

```bash
composer require superrb/kunstmaan-company
```

### Step 2: Add the admin routes

Add the following to your `/config/routes.yaml`

```yml
superrbkunstmaancompanybundle_company_admin_list:
    resource: '@SuperrbKunstmaanCompanyBundle/Controller/CompanyAdminListController.php'
    type:     annotation
    prefix:   /admin/company
```

### Step 3: Generate Database Tables

You can use Doctrine Migrations or a schema update, it is your choice

```bash
bin/console doctrine:migrations:diff
bin/console doctrine:migrations:migrate
```
or
```bash
bin/console doctrine:schema:update --force
```

## Usage

### Output Schema on a page of your choice

```html
  {{ generate_company_schema() }}
```

### Access the `company` Twig global

You can access the `company` Twig global from any template, for example if you wanted to output the phone number:
```html
<a href="tel:{{ company.phone | phone_number_format('INTERNATIONAL') }}">{{ company.phone | phone_number_format('NATIONAL') }}</a>
```

## Issues and Troubleshooting

All issues: tech@superrb.com
