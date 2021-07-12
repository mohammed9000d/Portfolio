<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $projects = Project::all();
        return view('admin.projects.index', ['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title' => 'required|string|min:3',
            'description' => 'required|string',
            'link' => 'required|string',
            'image' => 'required|image'
        ]);
        $project = new Project();
        $project->title = $request->get('title');
        $project->description = $request->get('description');
        $project->link = $request->get('link');
        if($request->hasFile('image')){
            $projectImage = $request->file('image');
            $ImageName = time().'_'. $request->get('title').'.'. $projectImage->getClientOriginalExtension();
            $projectImage->move('images/project',$ImageName);
            $project->image = $ImageName;
        }
        $isSaved = $project->save();
        if($isSaved) {
            session()->flash('alert-type', 'alert-success');
            session()->flash('message', 'Created project successfully');
            return redirect()->back();
        }else {
            session()->flash('alert-type', 'alert-danger');
            session()->flash('message', 'Failed to create project!');
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $project = Project::findOrfail($id);
        return view('admin.projects.edit', ['project' => $project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->request->add(['id'=>$id]);
        $request->validate([
            'id' => 'integer|exists:projects,id',
            'title' => 'required|string|min:3',
            'description' => 'required|string',
            'link' => 'required|string',
            'image' => 'required|image'
        ]);
        $project = Project::find($id);
        $project->title = $request->get('title');
        $project->description = $request->get('description');
        $project->link = $request->get('link');
        if($request->hasFile('image')){
            $projectImage = $request->file('image');
            $ImageName = time().'_'. $request->get('title').'.'. $projectImage->getClientOriginalExtension();
            $projectImage->move('images/project',$ImageName);
            $project->image = $ImageName;
        }
        $isSaved = $project->save();
        if($isSaved) {
            session()->flash('alert-type', 'alert-success');
            session()->flash('message', 'Updated project successfully');
            return redirect()->back();
        }else {
            session()->flash('alert-type', 'alert-danger');
            session()->flash('message', 'Failed to update project!');
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          //
        $isDeleted = Project::destroy($id);
        if($isDeleted){
            return response()->json([
                'title'=>'Success',
                'text'=>'Project deleted successfully',
                'icon'=>'success'
            ]);

        }else{
            return response()->json([
                'title'=>'Failed',
                'text'=>'Failed to delete project!',
                'icon'=>'error'
            ]);

        }
    }
}
