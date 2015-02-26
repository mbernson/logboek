<?php

use Illuminate\Database\Eloquent\SoftDeletingTrait;

class Custody extends Model {
  use SoftDeletingTrait;

  protected $table = 'custody';

  protected $fillable = ['name', 'characteristic', 'location', 'responsible',
                         'seized', 'date', 'time',
                         'description', 'details', 'signature', 'signature_name',
                         'signature_remark', 'signature_signed', 'signature_ip',
                         'signature_date', 'signature_time'];

  protected $rules = [
    'name' => 'required',
    'characteristic' => 'required',
    'location' => 'required',
    'responsible' => 'required',
    'seized' => 'required',
    'date' => 'required|date'
  ];

}
