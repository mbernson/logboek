<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Legal extends Model {
  use SoftDeletingTrait;

  protected $fillable = ['name', 'body', 'html_body', 'abbreviation', 'active'];

  protected $rules = [
    'name' => 'required',
    'body' => 'required',
    'abbreviation' => 'required',
    'active' => 'required',
  ];
}
