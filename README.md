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
{% for network in company.socialMedias %}
    <a href="{{ network.url }}"
       class="contact__link"
       target="_blank"
       rel="noopener">
        {{ network.key | capitalize }}
    </a>
{% endfor %}
```

## Issues and Troubleshooting

All issues: tech@superrb.com
