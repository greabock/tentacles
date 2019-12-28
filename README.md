# tentacles
This is fork from the package https://github.com/greabock/tentacles 
(https://packagist.org/packages/greabock/tentacles)
*Monkey-patching for eloquent models*

Composer
```
"do6po/tentacles": "dev-master"
```

user-model...    
```php   
<? namespace App\User\Models;

use Illuminate\Database\Eloquent\Model;
use Do6po\Tentacles\EloquentTentacle;

User extends Model {
  
  use EloquentTentacle;

}

```

ServiceProvider

```php
<?php namespace App\Article\Providers;

use Illuminate\Support\ServiceProvider;
use App\Article\Models\Article;
use App\User\Models\User;


use Illuminate\Database\Eloquent\Model;

class ArticleProvider extends ServiceProvider {

  public function register()
  {
    #..
  }
  
  public function boot()
  {
    User::addExternalMethod('articles', function()
    {
        return $this->hasMany(Article::class);
    });


    User::addExternalMethod('getFullnameAttribute', function()
    {
        return $this->first_name . ' ' . $this->last_name; 
    });
  }
  
}

```

Now we can do this:

```
$user = User::with('articles')->first();

$fullname = $user->fullname;
```





