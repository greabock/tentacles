# tentacles
laravel package for resolving relations... whut? I'd better show.

```
"greabock/tentacles": "0.02.*@dev"
```

user-model...
```php
<? namespace App\User\Models;

use Eloquent
use Greabock\Tentacles\Tentacle;

User extends Eloquent {
  
  use Tentacle;

}

```

SeviceProvider

```php
<?php namespace App\Article\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;
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
    User::addRelation('articles', function(User $model)
    {
      return $this->hasMany(Article::class);
    });
  }
  
}


```

Now we can do this:

```
$user = User::with('articles')->first();
```





