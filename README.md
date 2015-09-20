# tentacles


Composer
```
"greabock/tentacles": "dev-master"
```

user-model...    
```php   
<? namespace App\User\Models;

use Eloquent;
use Greabock\Tentacles\EloquentTentacle;

User extends Eloquent {
  
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

ArticleProvider extends ServiceProvider {

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





