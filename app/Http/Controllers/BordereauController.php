<?php

namespace App\Http\Controllers;

use App\Upload;
use App\Document;
use App\Http\Resources\Upload as UploadResource;
use Illuminate\Http\Request;

class BordereauController extends Controller
{
    public function home()
    {
        // if (!Gate::allows('isAdmin')) {
        //     abort(403, 'Désolé, vous ne pouvez pas executer cette action');
        // }

        return view('admin.uploads.bordereaux_index', [
            'page' => 'documents',
            'sub_page' => 'bordereaux'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = 100;
        if($request->has('limit'))
            $keyword = $request->limit;
        $keyword = '';
        if($request->has('keyword'))
            $keyword = $request->keyword;
        // if (!Gate::allows('isAdmin')) {
        //     abort(403, 'Désolé, vous ne pouvez pas executer cette action');
        // }

        $files = Upload::where('type', '=', 'bordereau')
            ->orderBy('uploaded_at', 'desc')->paginate($limit);

        return UploadResource::collection($files);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'],
            'uploaded_at' => ['required'],
            'description' => ['']
        ]);

        $upload = Upload::forceCreate([
            'name' => $data['name'],
            'uploaded_at' => new \DateTime($data['uploaded_at']),
            'description' => $data['description'],
            'type' => 'bordereau',
            // 'date_depot_ac' => Functions::stringToDate($data['date_depot_ac']),
        ]);

        $file = $request->document;
        $fileName = uniqid().$file->getClientOriginalName();
        $newFile = Document::forceCreate([
            'filename' => $fileName,
        ]);
        $upload->documents()->attach($newFile->id);
        $file->move(public_path('uploads/documents'), $fileName);

        return new UploadResource($upload);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function show(Upload $upload)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy($upload)
    {
        $upload = Upload::find($upload);

        if($upload->delete()){
            return new UploadResource($upload);
        }
    }
}
