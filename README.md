# guardian
CREY Framework Access Control List Component

### description

Guardian is the Resource based Access Control List implementation of CREY, a PHP 7 component-based Framework.

### Metrics of master branch

![Package Metrics](https://cdn.rawgit.com/crey-framework/guardian/master/package-metrics.svg)

### Usage

This brief introduction demonstrates how to use Guardian:

##### Role definition
```php
$blog = new \Crey\Guardian\Resource('blog', 'read', 'subscribe');
$article = new \Crey\Guardian\Resource('article', 'read', 'comment', 'delete', 'add', 'edit');
$comment = new \Crey\Guardian\Resource('comment', 'read', 'delete', 'edit');

$guest = new \Crey\Guardian\Role('guest');

$blog->grant($guest, 'read');
$article->grant($guest, 'read', 'comment');
$comment->grant($guest, 'read');

$admin = new \Crey\Guardian\Role('admin');
$admin->inherit($guest);

$article->grant($admin, 'delete', 'add', 'edit');
$comment->grant($admin, 'delete', 'edit');
```

##### Check for roles on roles
```php
if ( $admin->hasAccessTo($article) ) {
    // on general access
}

if ( $admin->hasAccessTo($article, 'read', 'add', 'delete') ) {
    // on access for specific actions
}
```

##### Check for roles on a resource
```php
if ( $article->allows($admin) ) {
    // on general access
}

if ( $article->allows($admin, 'read', 'add', 'delete') ) {
    // on access for specific actions
}
```

#### Maintainer and state of this package

The inventor and maintainer of this package is Matthias Kaschubowski.
This package is currently in alpha mode.

#### Meaning of staging modes

- [x] Alpha - No out-sourced documentation, no or incomplete tests
- [ ] Beta - out-sourced documentation, near to complete tests, CI
- [ ] Universe - production and development ready state with CI

#### Composer integration

This package will be available at packagist in beta mode. Until then
you have to manually link this package repository as a data resource
to your dependencies.