<?php

namespace App\Console\Commands\BebesLutins;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Carbon\Carbon;

class ImportOld extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature =
        'bebeslutins:import:old
            {--show : Show all success and errors messages}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all data from old bebes lutins website.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('
        ------------------------
        Beginning of importation
        ------------------------
        ');

        $this->importProducts();
        $this->importProductImages();
        $this->importCategories();
        $this->importCategoryImages();
        $this->importCategoryProductRelations();
        $this->importAdmins();
        $this->importUsers();
        $this->importAddresses();
        $this->importOrders();
        $this->importOrderItems();
    }

    protected function importProducts(): bool
    {
        if ($this->option('show')) {
            $this->info('All products are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/products');
        $result = json_decode($res->getBody());

        $count = 0;

        foreach ($result as $r) {
            $product = new \App\Product();
            $product->id = $r->id;
            $product->name = $r->name;
            $product->reference = $r->reference;
            $product->description = $r->description;
            $product->stock = $r->stock;
            $product->price = $r->price;
            $product->isHighlighted = $r->isHighlighted;
            $product->isHidden = $r->isHidden;
            $product->isDeleted = $r->isDeleted;
            $product->created_at = $r->created_at;
            $product->updated_at = $r->updated_at;

            try {
                $product->save();
            } catch(\Exception $e) {
                $this->error('Error happened on '.$r->name.' importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            $count++;
        }

        $this->info($count . ' products imported.');

        return 1;
    }

    protected function importProductImages(): bool
    {
        if ($this->option('show')) {
            $this->info('All product images are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/products/images');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach ($result as $r) {
            $image = new \App\Image();
            $image->name = $r->name;
            $image->url = '/images/products/' . $r->name;
            $image->size = isset($r->size) ? $r->size : 0;
            $image->created_at = $r->created_at;
            $image->updated_at = $r->updated_at;

            try {
                $image->save();
            } catch(\Exception $e) {
                $this->error('Error happened on '.$r->name.' importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            if (null !== $product = \App\Product::find($r->productId)) {
                $product->images()->attach([$image->id => ['rank' => $count]]);
            }

            $count++;
        }

        $this->info($count . ' product images 📸 imported.');

        return 1;
    }

    protected function importCategories(): bool
    {
        if ($this->option('show')) {
            $this->info('All categories are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/categories');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach($result as $r) {
            if (null === $r->id || '' === $r->id) {
                continue;
            }

            $category = new \App\Category();
            $category->id = $r->id;
            $category->name = $r->name;
            $category->description = $r->description;
            $category->rank = $r->rank;
            $category->isHidden = $r->isHidden;
            $category->isDeleted = $r->isDeleted;
            $category->created_at = $r->created_at;
            $category->updated_at = $r->updated_at;
            $category->parentId = $r->parent_id;

            try {
                $category->save();
            } catch(\Exception $e) {
                $this->error('Error happened on '.$r->name.' importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            $count++;
        }

        $this->info($count . ' categories imported !');

        return 1;
    }

    protected function importCategoryImages(): bool
    {
        if ($this->option('show')) {
            $this->info('All category images are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/categories/images');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach ($result as $r) {
            $image = new \App\Image();
            $image->name = $r->name;
            $image->url = '/images/categories/' . $r->name;
            $image->size = isset($r->size) ? $r->size : 0;
            $image->created_at = $r->created_at;
            $image->updated_at = $r->updated_at;

            try {
                $image->save();
            } catch(\Exception $e) {
                $this->error('Error happened on '.$r->name.' importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            if (null !== $category = \App\Category::find($r->categoryId)) {
                $category->images()->attach($image);
            }
            $count++;
        }

        $this->info($count . ' category images 📸 imported !');

        return 1;
    }

    protected function importCategoryProductRelations(): bool
    {
        if ($this->option('show')) {
            $this->info('All category product relations are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/categories/relations');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach($result as $r) {
            \App\Category::find($r->category_id)->products()->detach($r->product_id);
            \App\Category::find($r->category_id)->products()->attach($r->product_id);
            $count++;
        }

        $this->info($count . ' category product relations 🌀 imported !');

        return 1;
    }

    protected function importAdmins(): bool
    {
        if ($this->option('show')) {
            $this->info('All admins are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/admins');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach($result as $r) {
            if (\App\Admin::where('email', $r->email)->exists()) {
                continue;
            }

            $admin = new \App\Admin();
            $admin->uuid = Str::orderedUuid();
            $admin->firstname = $r->firstname;
            $admin->lastname = $r->lastname;
            $admin->email = $r->email;
            $admin->password = $r->password;
            $admin->role = 'ADMIN';
            $admin->created_at = $r->created_at;
            $admin->updated_at = Carbon::now()->toDateTimeString();

            try {
                $admin->save();
            } catch(\Exception $e) {
                $this->error('Error happened on '.$r->firstname.' '.$r->lastname.' importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            $count++;
        }

        $this->info($count . ' admins ⭐️ imported !');

        return 1;
    }

    protected function importUsers(): bool
    {
        if ($this->option('show')) {
            $this->info('All users are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/customers');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach($result as $r) {
            if (\App\User::where('email', $r->email)->exists()) {
                continue;
            }

            $user = new \App\User();
            $user->firstname = $r->firstname;
            $user->lastname = $r->lastname;
            $user->phone = $r->phone;
            $user->email = $r->email;
            $user->password = $r->password;
            $user->wantNewsletter = $r->wantNewsletter;
            $user->created_at = $r->created_at;
            $user->updated_at = $r->updated_at;

            try {
                $user->save();
            } catch(\Exception $e) {
                $this->error('Error happened on '.$r->firstname.' '.$r->lastname.' importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            $count++;
        }

        $this->info($count . ' users 👨‍💻 imported !');

        return 1;
    }

    protected function importAddresses(): bool
    {
        if ($this->option('show')) {
            $this->info('All addresses are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/addresses');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach($result as $r) {
            if (null === $r->id || '' === $r->id) {
                continue;
            }

            $address = new \App\Address();
            $address->firstname = $r->firstname;
            $address->lastname = $r->lastname;
            $address->civility = $this->integerCivilityToStringCivility($r->civility);
            $address->street = $r->street;
            $address->zipCode = $r->zipCode;
            $address->city = $r->city;
            $address->complements = $r->complement;
            $address->company = $r->company;
            $address->user_id = $r->isDeleted && $r->user_id ? null : (\App\User::where('email', $r->user_mail)->exists() ? \App\User::where('email', $r->user_mail)->first()->id : null);
            $address->created_at = $r->created_at;
            $address->updated_at = $r->updated_at;

            try {
                $address->save();
            } catch(\Exception $e) {
                $this->error('Error happened on address ['.$r->id.'] importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            $count++;
        }

        $this->info($count . ' addresses 🏠 imported !');

        return 1;
    }

    protected function importOrders(): bool
    {
        if ($this->option('show')) {
            $this->info('All orders are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/orders');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach ($result as $r) {
            $order = new \App\Order();
            $order->status = $this->integerStatusToStringStatus($r->status);
            $order->paymentMethod = $this->integerPaymentMethodToStringPaymentMethod($r->paymentMethod);
            $order->shippingCosts = $r->shippingPrice;
            $order->email = $r->user->email;
            $order->phone = $r->user->phone;
            $order->trackingNumber = $r->id;
            $order->comment = $r->customerMessage;
            $order->billing_address_id = \App\Address::where('street', $r->billing_address->street)->where('lastname', $r->billing_address->lastname)->first()->id;
            $order->shipping_address_id = $r->shipping_address ? \App\Address::where('street', $r->shipping_address->street)->where('lastname', $r->shipping_address->lastname)->first()->id : null;
            $order->user_id = $r->user ? (\App\User::where('email', $r->user->email)->exists() ? \App\User::where('email', $r->user->email)->first()->id  : null) : null;
            $order->created_at = $r->created_at;
            $order->updated_at = $r->updated_at;

            try {
                $order->save();
            } catch(\Exception $e) {
                $this->error('Error happened on order ['.$r->id.'] importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            $count++;
        }

        $this->info($count . ' orders 📦 imported !');

        return 1;
    }

    protected function importOrderItems(): bool
    {
        if ($this->option('show')) {
            $this->info('All order items are gonna be imported.');
        }

        $client = new Client();
        $res = $client->get('https://bebes-lutins.fr/api/orders/items');
        $result = json_decode($res->getBody());

        $count = 0;
        foreach ($result as $r) {
            $orderItem = new \App\OrderItem();
            $orderItem->quantity = $r->quantity;
            $orderItem->unitPrice = $r->unitPrice;
            $orderItem->order_id = \App\Order::where('email', $r->order->user->email)->where('created_at', $r->order->created_at)->first()->id;
            $orderItem->product_id = $r->product_id;
            $orderItem->created_at = $r->created_at;
            $orderItem->updated_at = $r->updated_at;

            try {
                $orderItem->save();
            } catch(\Exception $e) {
                $this->error('Error happened on order item ['.$r->id.'] importation.');
                $this->error('ERROR : ' . $e->getMessage());
            }

            $count++;
        }

        $this->info($count . ' order items 🏷  imported !');

        return 1;
    }

    /**
     * Convert old integer civility to new string civility.
     *
     * @param int $civility The civility in int format.
     * @return string The civility in string format.
     */
    protected function integerCivilityToStringCivility(int $civility): string
    {
        switch ($civility) {
            case 0:
                return 'MISS';
            break;
            case 1:
                return 'MISTER';
            break;
            case 2:
                return 'MISS';
            break;
            default:
            return 'NOT_DEFINED';
        }
    }

    /**
     * Convert old integer status new string status.
     *
     * @param int $civility The status in int format.
     * @return string The status in string format.
     */
    public function integerStatusToStringStatus(int $status): string
    {
        switch ($status) {
            case 0:
                return 'WAITING_PAYMENT';
            break;
            case 1:
                return 'PROCESSING';
            break;
            case 2:
                return 'DELIVERING';
            break;
            case 22:
                return 'WITHDRAWAL';
            break;
            case 3:
                return 'DELIVERED';
            break;
            case 33:
                return 'REGISTERED_PARTICIPATION';
            break;
            case -1:
                return 'CANCELED';
            break;
            case -2:
                return 'REFUSED_PAYMENT';
            break;
            case -3:
                return 'REFUSED_PAYMENT';
            break;
            default:
                return 'STATUS_ERROR';
            break;
        }
    }

    /**
     * Convert old integer payment method to new string payment method.
     *
     * @param int $civility The payment method in int format.
     * @return string The payment method in string format.
     */
    public function integerPaymentMethodToStringPaymentMethod(int $paymentMethod): string
    {
        switch ($paymentMethod) {
            case 1:
                return 'CARD';
            break;
            case 2:
                return 'CHEQUE';
            break;
            default:
                return 'PAYMENT_METHOD_ERROR';
            break;
        }
    }
}
