<?php

class Setting extends Model {
  protected $fillable = ['key', 'value'];

  protected static $expireTime = 5; // minutes

  public static function get($key) {
	  if(Cache::has($key)) {
		  return Cache::get($key);
	  }

	  $result = static::where('key', '=', $key);
	  $setting = $result->first();

	  if(!$setting)
		  return null;

	  Cache::put($setting->key, $setting->value, self::$expireTime);
	  return $setting->value;
  }

  public static function set($key, $value) {
	  $setting = Setting::firstOrNew(['key' => $key]);
	  $setting->key = $key;
	  $setting->value = $value;

	  Cache::put($key, $value, self::$expireTime);

	  return $setting->save();
  }

  public static function contains($key, $string) {
	  return strpos(static::get($key), $string) !== false;
  }
}
