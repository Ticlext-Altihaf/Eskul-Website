<?php

namespace App\Controllers;

use App\Models\ClubModel;
use Exception;

class Editor extends BaseController
{
    protected $helpers = ['form'];

    public function index()
    {

        $data = [
            'name' => session()->get('name'),
        ];
        $clubModel = model('App\Models\ClubModel');
        $data['clubs'] = $clubModel->findAll();
        $data["keys_field"] = $clubModel->allowedFields;
        return view('editor/index', $data);
    }

    public function delete($club_name)
    {
        if (!$this->isValidEditor($club_name)) {
            //get previous url
            return view('editor/error', ['error' => 'You are not authorized to delete this club']);//TODO translate
        }
        $clubModel = model('App\Models\ClubModel');
        try {
            $clubModel->where('name', $club_name)->delete();
        } catch (Exception $e) {

        }
        #redirect to previous page
        return redirect()->to(previous_url());
    }

    //read only

    function isValidEditor($club): bool
    {
        $role = session()->get('role');
        //if editor or higher, return true
        $cardinal = \App\Models\Admin::get_role_cardinality($role);
        if ($cardinal < 3) {
            return True;
        }
        if ($cardinal == 3) {
            //if editor_club, check if club is the same
            if ($club == session()->get('admin_club')) {
                return True;
            }
        }
        return False;
    }

    public function deleteAll()
    {

        if (!$this->isEditorOrHigher()) {
            //get previous url
            return view('editor/error', ['error' => 'You are not authorized to delete this club']);//TODO translate
        }
        $clubModel = model('App\Models\ClubModel');
        try {
            $clubModel->builder()->truncate();
        } catch (Exception $e) {
            return view('editor/error', ['error' => $e->getMessage()]);//TODO translate
        }
        #redirect to previous page
        return redirect()->back();
    }

    function isEditorOrHigher(): bool
    {
        $role = session()->get('role');
        $cardinal = \App\Models\Admin::get_role_cardinality($role);
        return $cardinal <= 2;
    }

    public function add()
    {
        $role = session()->get('role');
        //if lower than editor, redirect to index page
        if (\App\Models\Admin::get_role_cardinality($role) > 2) {
            //redirect to index page
            return redirect()->to(base_url('/'));
        }

        //post ?
        if ($this->request->getPost()) {
            $clubModel = model('App\Models\ClubModel');
            $validationRule = [
                'icon' => [
                    'label' => 'Image Icon',
                    'rules' => 'uploaded[icon]'
                        . '|is_image[icon]'
                        . '|mime_in[icon,image/jpg,image/jpeg,image/gif,image/png,image/webp]'
                ],
                'name' => [
                    'label' => 'Name',
                    'rules' => 'required'
                ],
            ];
            $this->validator->setRules($validationRule);
            if (!$this->validate($validationRule)) {
                return redirect()->with('errors', $this->validator->getErrors())->back();
            }
            $club = array();
            $club['display_name'] = $this->request->getVar('name') ?? '';
            if ($club['display_name'] == '') {
                return redirect()->with('error', 'Name is required')->back();
            }
            $club['name'] = ClubModel::display_name_to_id($club['name']);
            if ($clubModel->find($club['name']) != null) {
                return redirect()->with('error', 'Club already exists')->back();
            }

            /*
             * 'name',//lowercase for id
        'display_name',//nama organisasi
        'coach_name',//nama pembina
        'chairman_name',//nama pimpinan
        'vice_chairman_name',//nama wakil pimpinan
        'timetable',//jadwal kegiatan (jumat dan ...)
        'vision',//visi
        'mission',//misi
        'work_program',//program kerja
        'icon',//icon organisasi (data:image/png;base64) or src="data here"
        'instagram',//instagram
             */
            $club['coach_name'] = $this->request->getVar('coach_name') ?? '';
            $club['chairman_name'] = $this->request->getVar('chairman_name') ?? '';
            $club['vice_chairman_name'] = $this->request->getVar('vice_chairman_name') ?? '';
            $club['timetable'] = $this->request->getVar('timetable') ?? '';
            $club['vision'] = $this->request->getVar('vision') ?? '';
            $club['mission'] = $this->request->getVar('mission') ?? '';
            $club['work_program'] = $this->request->getVar('work_program') ?? '';
            $club['icon'] = '';
            $club['instagram'] = $this->request->getVar('instagram') ?? '';

            if ($club['timetable'] == '') {
                return redirect()->with('error', 'Timetable is required')->back();
            }
            if (strpos($club['instagram'], '@') === 0) {
                //remove it
                $club['instagram'] = substr($club['instagram'], 1);
            }
            $img = $this->request->getFile('icon');
            if ($img->isValid()) {
                if ($img->getError() == 0) {
                    if (!$img->hasMoved()) {
                        $img->move('/images/icon/', null, true);
                    }
                    $club['icon'] = $img->getPathname();
                } else {
                    return redirect()->with('error', 'Icon is invalid: ' . $img->getErrorString())->back();
                }
            }
            try {
                $clubModel->insert($club);
                return redirect()->to(base_url($club['name']));
            } catch (Exception $e) {
                return redirect()->with('error', 'Error: ' . $e->getMessage())->back();
            }
        }
        return view('editor/add');
    }

    public function import()
    {
        //get xlsx file
        if (!$this->isEditorOrHigher()) return redirect()->back();

        $file = $this->request->getFile('file');

        if ($file != null) {
            if (!$file->isValid()) {
                return view("editor/import", array('error' => 'File is invalid: ' . $file->getErrorString()));
            }
            if ($file->getError() != 0) {
                return view("editor/import", array('error' => 'File is invalid: ' . $file->getErrorString()));
            }
            $file_path = $file->getPathname();
            try {
                ClubModel::import($file_path);
                return redirect()->to(route_to('editor'));
            } catch (Exception $e) {
                return view("editor/import", array('error' => $e->getMessage()));
            }
        }
        return view('editor/import');
    }

    public function edit($name)
    {
        if (!$this->isValidEditor($name)) return redirect()->back();
        $clubModel = model('App\Models\ClubModel');
        $club = $clubModel->find($name);
        if ($club == null) {
            return view('editor/error', ['error' => 'Club not found']);//TODO translate
        }
        $display_name = $this->request->getVar('display_name');
        if ($display_name != null) {
            if ($display_name == '') {
                return redirect()->with('error', 'Name is required')->back();
            }
            $club['display_name'] = $display_name;
            $club['name'] = ClubModel::display_name_to_id($display_name);
            $club['coach_name'] = $this->request->getVar('coach_name') ?? $club['coach_name'];
            $club['chairman_name'] = $this->request->getVar('chairman_name') ?? $club['chairman_name'];
            $club['vice_chairman_name'] = $this->request->getVar('vice_chairman_name') ?? $club['vice_chairman_name'];
            $club['timetable'] = $this->request->getVar('timetable') ?? $club['timetable'];
            $club['vision'] = $this->request->getVar('vision') ?? $club['vision'];
            $club['mission'] = $this->request->getVar('mission') ?? $club['mission'];
            $club['work_program'] = $this->request->getVar('work_program') ?? $club['work_program'];
            $club['instagram'] = $this->request->getVar('instagram') ?? $club['instagram'];
            $icon_file = $this->request->getFile('icon');
            if ($icon_file->isValid()) {
                if ($icon_file->getError() == 0) {
                    $dir = ROOTPATH.'/public/images/icon/';
                    $file_name = $name.'.'.$icon_file->getExtension();
                    if (!$icon_file->hasMoved()) {
                        $icon_file->move($dir, $file_name, true);
                    }
                    $club['icon'] = '/images/icon/'.$file_name;
                } else {
                    return redirect()->with('error', 'Icon is invalid: ' . $icon_file->getErrorString())->back();
                }
            }
            try {
                $clubModel->update($name, $club);
                return redirect()->to(route_to('editor'));
            } catch (Exception $e) {
                return redirect()->with('error', 'Error: ' . $e->getMessage())->back();
            }

        }
        $club['timetables'] = ClubModel::$timetables;
        return view('editor/edit', $club);
    }
}
