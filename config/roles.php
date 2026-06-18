<?php

// Canonical role → module access map. Single source of truth for both the
// backend (middleware, policies) and the SPA (which receives each user's
// resolved module list on the auth payload — see User::$appends 'modules').
//
// `gated` lists the modules that are access-restricted. Anything not listed
// here (dashboard, customers, employees, tasks) is open to any authenticated
// user. The `users` admin area is gated separately by the `admin` middleware.
return [
    'gated' => [
        'inventory_products',
        'orders',
        'deliveries',
        'purchase_orders',
    ],

    // '*' means "every gated module" (admins, and future modules auto-granted).
    'roles' => [
        'admin' => ['*'],
        'manager' => ['inventory_products', 'orders', 'deliveries', 'purchase_orders'],
        'deliveries' => ['orders', 'deliveries'],
        'orders' => ['orders'],
        'warehouse' => ['inventory_products', 'purchase_orders'],
        'staff' => [],
    ],
];
