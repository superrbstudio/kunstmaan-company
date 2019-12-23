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
    prefix:   /%kunstmaan_admin.admin_prefix%/company

superrbkunstmaancompanybundle_address_admin_list:
    resource: '@SuperrbKunstmaanCompanyBundle/Controller/AddressAdminListController.php'
    type:     annotation
    prefix:   /%kunstmaan_admin.admin_prefix%/company/address
```

### Step 3: Generate Database Tables

> **IMPORTANT:** If upgrading KunstmaanCompanyBundle from 1.x.x to 2.x.x, you will need to migrate existing data prior to running any Doctrine commands, to avoid losing address data.

    ```bash
    bin/console superrb:kunstmaan-company:migrate-addresses
    ```

    If you need to roll back, add `--rollback` to the command above

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

```twig
  {{ generate_company_schema() | raw }}
```

### Access the `company` Twig global

You can access the `company` Twig global from any template, for example if you wanted to output the phone number:
```twig
{% if company.phone is not empty %}
<a href="tel:{{ company.phone | phone_number_format('INTERNATIONAL') }}">{{ company.phone | phone_number_format('NATIONAL') }}</a>
{% endif %}
```

### Get the Address 
```twig
{{ company.address("\n") | nl2br }}
```
You can send a delimiter for the address parts, e.g. a comma or new line.

### Get Social Medias
You can retrieve a list of the available social media links available for the company. The example shows how you can easily create a list of icons and links.
```twig
<ul class="social">
    {% for network in company.socialMedias %}
        <li class="social-item">
            <a href="{{ network.url }}"
               class="social-link social-link--{{ network.key }}"
               target="_blank"
               rel="noopener">
                <span class="screenreader-text">{{ network.key | capitalize }}</span>
            </a>
        </li>
    {% endfor %}
</ul>
```

## Issues and Troubleshooting

All issues: tech@superrb.com
