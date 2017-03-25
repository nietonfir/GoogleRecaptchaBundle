GoogleReCaptchaBundle
=====================

[ReCAPTCHA](https://developers.google.com/recaptcha/) is a free CAPTCHA service that protects websites from spam and abuse.
This bundle uses the [GoogleReCaptcha](https://github.com/nietonfir/GoogleReCaptcha) library or validating a users "No CAPTCHA reCAPTCHA" response and provides a custom form type, a custom validation constraint as well as a validator to use with the [Symfony Form Component](https://github.com/symfony/Form).

[![Latest Stable Version](https://poser.pugx.org/nietonfir/google-recaptcha-bundle/v/stable.svg)](https://packagist.org/packages/nietonfir/google-recaptcha-bundle) [![Latest Unstable Version](https://poser.pugx.org/nietonfir/google-recaptcha-bundle/v/unstable.svg)](https://packagist.org/packages/nietonfir/google-recaptcha-bundle) [![License](https://poser.pugx.org/nietonfir/google-recaptcha-bundle/license.svg)](https://packagist.org/packages/nietonfir/google-recaptcha-bundle)

Installation
------------

The recommended way to install GoogleReCaptchaBundle is through
[Composer](http://getcomposer.org).

```bash
# Install Composer
curl -sS https://getcomposer.org/installer | php
```

Next, run the Composer command to install the latest stable version of GoogleReCaptcha:

```bash
composer require "nietonfir/google-recaptcha-bundle"
```

Or add GoogleReCaptchaBundle in your `composer.json`

```js
"require": {
    "nietonfir/google-recaptcha-bundle": "@stable"
}
```

and tell Composer to install the library:

``` bash
composer update "nietonfir/google-recaptcha-bundle"
```

After installing, don't forget to enable the bundle:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Nietonfir\Google\ReCaptchaBundle\NietonfirGoogleReCaptchaBundle(),
    );
}
```

Configuration
-------------

Add the following simple configuration to your `config.yml`.
```yaml
nietonfir_google_recaptcha:
    sitekey: <your_site_key_here>
    secret: <and_your_secret_here>
    validation: '<your_form_name>'
```

### Multiple forms

ReCaptcha can also be added to different forms (while not on the same page!):
```yaml
nietonfir_google_recaptcha:
    validation: [ '<your_form_name_A>', '<your_form_name_B>' ]
```

### Custom form field name

The form field name containing the recaptcha response, which defaults to `recaptcha`, can be customized as well:
```yaml
nietonfir_google_recaptcha:
    validation:
        forms:
            - {form_name: '<your_form_name_A>', field_name: 'recaptcha'}
            - {form_name: '<your_form_name_B>', field_name: 'recaptcha'}
```

Additionally you have to add the corresponding form field themes depending on
your used templating engine in `config.yml`.

```yaml
# Twig
twig:
    debug:            "%kernel.debug%"
    strict_variables: "%kernel.debug%"
    form_themes:
        - 'NietonfirGoogleReCaptchaBundle:Form:fields.html.twig'

# PHP
framework:
    templating:
        form:
            resources:
                - 'NietonfirGoogleReCaptchaBundle:Form'
```

Usage
-----

Using the Bundle is dead simple:

1. Create your form type as usual
2. Add a field using the `recaptcha` field type
    
    ```php
    use Nietonfir\Google\ReCaptchaBundle\Form\Type\ReCaptchaType;
    
    $builder->add('recaptcha', ReCaptchaType::class);
    ```
    
3. Add the necessary javascript library to your template
    ```html
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    ```

4. Make your controller implement `ReCaptchaValidationInterface`
    
    ```php
    use Nietonfir\Google\ReCaptchaBundle\Controller\ReCaptchaValidationInterface;

    class DefaultController extends Controller implements ReCaptchaValidationInterface
    ```
    
Now when `form->isValid()` is called, the submitted reCAPTCHA response is validated against the Google API.
Be advised that both the form and the field name used have to be set in `config.yml`.

TODOs
-----
* [x] Add some `info()` to the form & field name config values in `Configuration.php`
* [x] Translate the error messages returned from the Google API to something more meaningful
* [ ] Update documentation
* [ ] Add some more examples
* [x] Add missing unit tests
