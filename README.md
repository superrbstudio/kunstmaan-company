# SuperrbKunstmaanCompanyBundle

## Installation

### Step 1: Install the Bundle

```bash
composer require superrb/kunstmaan-company
```

### Step 2: Enable the Bundle

Enable the bundle in your `app/AppKernel.php` for your project

```php
<?php
// app/AppKernel.php

// ...
class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            // ...

            new Superrb\KunstmaanCompanyBundle\SuperrbKunstmaanCompanyBundle(),
        );

        // ...
    }

    // ...
}
```

### Step 3: Add the routes

Add the following to your `app/config/routing.yml`

```yml
superrbkunstmaansocialmediabundle_company_admin_list:
    resource: '@SuperrbKunstmaanCompanyBundle/Controller/CompanyAdminListController.php'
    type:     annotation
    prefix:   /admin/company
```

### Step 4: Generate Database Tables

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

### Example schema

```html
  {% if company is defined and company is not empty %}
    {% set openingHours = [] %}
    {% if company.days is defined and company.days is not empty %} 
      {% for day in company.days %}
        {% set openingHours = openingHours|merge(['{
          "@type": "OpeningHoursSpecification",
          "dayOfWeek": "' ~ day.day ~ '",
          "opens": "' ~ day.openTime ~ '",
          "closes":"' ~ day.closeTime ~ '"
        }']) %}
      {% endfor %}
    {% endif %}

    {% spaceless %}
      <script type="application/ld+json">
        { 
          "@context": "http://schema.org",
          "@type": "LocalBusiness",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ company.streetAddress }}",
            "addressLocality": "{{ company.addressLocality }}",
            "addressRegion" : "{{ company.addressRegion }}",
            "postalCode":"{{ company.postcode }}",
            "addressCountry": "{{ company.addressCountry }}"
          },
          "url":"{{ url("_slug") }}",
          "telephone": "{{ company.phone }}",
          "email" : "{{ company.email }}",
          "name": "{{company.companyName}}",
          "sameAs" : [ 
            "{{ company.facebook }}",
            "{{ company.twitter }}",
            "{{ company.instagram }}"
          ],
          "openingHoursSpecification" :  [{{openingHours|join(',')|raw }}]
        }
      </script>
    {% endspaceless %}

  {% endif %}
```

## Issues and Troubleshooting

All issues: tech@superrb.com
