<?php

namespace App\Http\Livewire\Admin\Announcements;

use App\Models\Announcement as AnnouncementModel;
use App\Models\AnnouncementDetail as AnnouncementDetailModel;
use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\File;


class AnnouncementDetailsWired extends Component
{
    use WithFileUploads;

    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $moment_img_path = 'moment_imgs';


    public $announcement_key_moments;

    public $current_tab = 0;
    public $limit = 200;
    public $current_announcement_name;
    public $current_announcement_id;
    public $current_keyMoment_toDelete;
    public $current_keyMoment_index;
    public $counter = 0;
    public $image_file;

    public $max_key_moments = 10;
    protected $listeners=['confirm_delete_key_moment'];
    // max_key_moments is needed so as to know control the amount of temp_pic variables to declare for the key moments

    public $temp_pic_0, $temp_pic_1, $temp_pic_2, $temp_pic_3, $temp_pic_4, $temp_pic_5, $temp_pic_6, $temp_pic_7, $temp_pic_8, $temp_pic_9;
    // update this anytime u update the $max_key_moments

    protected $rules = [
        'announcement_key_moments.*.image_description' => "required|string",
        'announcement_key_moments.*.image_sub_title' => "nullable|string",

        'temp_pic_0' => "nullable|image",
        'temp_pic_1' => "nullable|image",
        'temp_pic_2' => "nullable|image",
        'temp_pic_3' => "nullable|image",
        'temp_pic_4' => "nullable|image",
        'temp_pic_5' => "nullable|image",
        'temp_pic_6' => "nullable|image",
        'temp_pic_7' => "nullable|image",
        'temp_pic_8' => "nullable|image",
        'temp_pic_9' => "nullable|image",
    ];
    protected $messages = [
        'announcement_key_moments.*.image_description' => 'kindly provide a key moment description for this announcement',
        'announcement_key_moments.*.image_sub_title' => 'kindly provide a valid key moment statement/leave blank for this announcement',
        'temp_pic_0' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_1' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_2' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_3' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_4' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_5' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_6' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_7' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_8' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',
        'temp_pic_9' => 'kindly provide a key moment [IMAGE] /leave blank for this announcement',

    ];

    // current_tab will default to 0 as looping starts from 0
    public function tab_clicked($tab_id)
    {
        $this->current_tab = $tab_id;
        // dd($this->current_tab);
    }

    // method for writing images and returning just its name
    public function store_pic($media_file, $moment_file_name)
    {
        $uploaded_img_path = public_path() . '\\storage\\' . $this->moment_img_path . '\\';

        if(!File::exists($uploaded_img_path)){
            // checking if path to this image file exsists and creating a foldeer for it if it doesnt exsist
            File::makeDirectory($uploaded_img_path);
        }

        if (!empty($media_file)) {
            $file_ext = $media_file->getClientOriginalExtension();
            $new_file_name = 'key_moment' . "_" . $moment_file_name . "_." . $file_ext;

            $img = Image::make($media_file);
            $img->save($uploaded_img_path . $new_file_name);

        }
        return $new_file_name;

    }

    // method for removing uploaded images if not needee
    public function remove_moment_img_temp($index)
    {
        switch ($index) {
            case 0:
                $this->temp_pic_0 = "";
                break;
            case 1:
                $this->temp_pic_1 = "";
                break;
            case 2:
                $this->temp_pic_2 = "";
                break;
            case 3:
                $this->temp_pic_3 = "";
                break;
            case 4:
                $this->temp_pic_4 = "";
                break;
            case 5:
                $this->temp_pic_5 = "";
                break;
            case 6:
                $this->temp_pic_6 = "";
                break;
            case 7:
                $this->temp_pic_8 = "";
                break;
            case 8:
                $this->temp_pic_8 = "";
                break;
            case 9:
                $this->temp_pic_9 = "";
                break;

        }

    }

    // remove a db image for key moment
    public function remove_moment_img_perm($key_moment_id, $index, $show_msg = true)
    {
        //removes temporary image for this key moment if it exsists
        $this->remove_moment_img_temp($index);

        $img_obj = AnnouncementDetailModel::findOrFail($key_moment_id);
        AnnouncementDetailModel::where('id', $key_moment_id)->update(["image" => ""]);

        Storage::disk('public')->delete($this->moment_img_path . '/' . $img_obj->image);

        if ($show_msg == true) {
            $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => "key moment image removed successfully!"]);

        }

    }
    public function remove_key_moment($index, $key_moment){
        $this->current_keyMoment_toDelete=$key_moment;
        $this->current_keyMoment_index=$index;
        $this->dispatchBrowserEvent('show_delete_key_moment');


    }

    public function confirm_delete_key_moment()
    {

        if (!empty($this->array_to_object( $this->current_keyMoment_toDelete)->image)) {
            //if this keymoment has an image, I am deleting it before proceeding...

            $moment_id = $this->array_to_object( $this->current_keyMoment_toDelete)->id;
            $this->remove_moment_img_perm($moment_id, $this->current_keyMoment_index, false);

        }
        $announcement_key_moment = $this->announcement_key_moments[$this->current_keyMoment_index];
        $announcement_key_moment->delete();
        $this->announcement_key_moments->forget($this->current_keyMoment_index);
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => "key moment deleted successfully!"]);




    }
    private function array_to_object($array)
    {
        return (object) $array;

    }

    public function get_key_moments($announcement_id)
    {

        $this->announcement_key_moments = AnnouncementDetailModel::all()
        ->where('announcement_id', $announcement_id);

        dd($this->announcement_key_moments->toArra());
        // this works in a controller but not in blade



        $this->current_announcement_id = $announcement_id;
        $this->current_announcement_name = AnnouncementModel::where(['id' => $this->current_announcement_id])->first()->title;

        $this->dispatchBrowserEvent('show_announcement_key_moments');
    }
    public function add_announcement_keyMoment()
    {
        if ($this->counter < $this->max_key_moments) {
            $this->counter += 1;
            $announcement_instance = AnnouncementDetailModel::make();
            $this->announcement_key_moments->push($announcement_instance);

        }

    }

    public function set_key_moment_attr($index)
    {
        //this is used to set the currently looped (announcement_instance) inorder to update or store its picture
        switch ($index) {
            case 0:
                $this->image_file = $this->temp_pic_0;
                break;
            case 1:
                $this->image_file = $this->temp_pic_1;
                break;
            case 2:
                $this->image_file = $this->temp_pic_2;
                break;
            case 3:
                $this->image_file = $this->temp_pic_3;
                break;
            case 4:
                $this->image_file = $this->temp_pic_4;
                break;
            case 5:
                $this->image_file = $this->temp_pic_5;
                break;
            case 6:
                $this->image_file = $this->temp_pic_6;
                break;
            case 7:
                $this->image_file = $this->temp_pic_8;
                break;
            case 8:
                $this->image_file = $this->temp_pic_8;
                break;
            case 9:
                $this->image_file = $this->temp_pic_9;
                break;

        }

    }

    public function get_key_moment_attr($index)
    {
        //this is used to get the currently looped (announcement_instance) inorder to display on the frontend
        switch ($index) {
            case 0:
                return $this->temp_pic_0;
                break;
            case 1:
                return $this->temp_pic_1;
                break;
            case 2:
                return $this->temp_pic_2;
                break;
            case 3:
                return $this->temp_pic_3;
                break;
            case 4:
                return $this->temp_pic_4;
                break;
            case 5:
                return $this->temp_pic_5;
                break;
            case 6:
                return $this->temp_pic_6;
                break;
            case 7:
                return $this->temp_pic_8;
                break;
            case 8:
                return $this->temp_pic_8;
                break;
            case 9:
                return $this->temp_pic_9;
                break;

        }

    }
    public function add_new_announcement()
    {
        //dd($this->announcement_key_moments->toArray()!=[]);


        $this->validate($this->rules, $this->messages);

        foreach ($this->announcement_key_moments as $index => $key_moment) {

            $this->set_key_moment_attr($index);
            // setting the value for the key_moment(image_file) based on its index

            $microtime = microtime(true);

            $random_name = Str::random(5) . '-' . (string) $microtime;

            $key_moment->announcement_id = $this->current_announcement_id;
            if (!empty($this->image_file)) {
                // set_key_moment_attr() is set so we can use it now if its not empty
                $key_moment->image = $this->store_pic($this->image_file, $random_name);
            }

            $key_moment->save();

            // clear input fields after upload
            $this->dispatchBrowserEvent('clear_file_fields');
        }

        // deleting all 10 temp images counting from 0 to 9 with the count serving as indexes
        for ($i = 0; $i < 10; $i++) {
            $this->remove_moment_img_temp($i);
        }

        $this->dispatchBrowserEvent('hide_announcement_key_moments', );
        $this->dispatchBrowserEvent('show-success-toast', ["success_msg" => "[" . $this->current_announcement_name . "]" . " key moments updated successfully!"]);

    }

    public function render()
    {
        $categories = CategoryModel::where('status', 1)->latest()->get();
        // dd($announcements);

        return view('livewire.admin.announcements.announcement-details-wired')->with(compact('categories'));

    }
}