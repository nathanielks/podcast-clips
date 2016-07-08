<?php

namespace WPPPT\Admin\Pages;

interface Page {
    public function enqueue_scripts();
    public function add_menu_pages();
    public function process_form();
    public function render();
}
