<?php

class Setting extends Model {

  protected $table = 'settings';

  protected $softDelete = false;

  protected $fillable = ['id', 'project_name', 'vw_menu_entries', 'vw_menu_logbooks',
                         'vw_menu_tasks', 'vw_menu_attachments', 'vw_menu_evidences',
                         'vw_menu_exports', 'vw_menu_cipher'];

  protected $rules = [
    'project_name' => 'required',
    ];

}
