<?php

namespace App\Http\Livewire\Admin\Announcements;
use App\Models\Announcement as AnnouncementModel;
use App\Models\Category as CategoryModel ;
use Livewire\Component;
use Livewire\WithPagination;


class AnnouncementDetailsWired extends Component
{
use WithPagination;
protected $paginationTheme = 'bootstrap';

    public $current_tab=0;
    // current_tab will default to 0 as looping starts from 0
    public function tab_clicked ($tab_id){
        $this->current_tab=$tab_id;
        // dd($this->current_tab);
    }
    public function render()
    {
        $categories = CategoryModel::where('status',1)->latest()->get();
        // dd($announcements);

        return view('livewire.admin.announcements.announcement-details-wired')->with(compact('categories'));
    }
}