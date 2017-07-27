<?php

namespace LoremPublishing\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use LoremPublishing\Events\PublicationUpdated;
use LoremPublishing\Http\Controllers\Controller;
use LoremPublishing\Publication;

class PublicationsController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->has('tag')) {
            $publications = Publication::whereHas('tags', function ($query) use ($request) {

                $query->where('title', $request->tag);

            })->with('tags')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $publications = Publication::with('tags')->orderBy('created_at', 'desc')->paginate(10);
        }

        $contectType = $request->header('Content-Type');

        if ($contectType === 'application/json') {
            return response()->json($publications);
        } elseif ($contectType === 'application/xml') {
            return response()->xml($publications);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'text' => 'required|min:10',
            'cover_image' => 'mimes:png,jpeg,jpg,bmp',
        ]);

        if ($validator->fails()) {
            return response('Basic validation failed', 422);
        }

        $publication = Auth::guard('api')->user()->publications()->create($request->all());

        $publication->syncTags($request);

        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $uid = uniqid();

            $image = $request->file('cover_image');
            Image::make($image)->resize(128, 128) > encode('jpg')->save('images/' . $uid . '.jpg');

            $publication->cover_image = $uid;
            $publication->save();
        }

        event(new PublicationUpdated($publication));

        $contectType = $request->header('Content-Type');

        return response()->json($publication);
    }


    /**
     * @param Publication $publication
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, Publication $publication)
    {
        $contectType = $request->header('Content-Type');

        if ($contectType === 'application/json') {
            return response()->json($publication);
        } elseif ($contectType === 'application/xml') {
            return response()->xml($publication);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Publication $publication)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3|max:255',
            'text' => 'required|min:10',
            'cover_image' => 'mimes:png,jpeg,jpg,bmp',
        ]);

        if ($validator->fails()) {
            return response('Basic validation failed', 422);
        }

        $publication->update($request->all());

        $publication->syncTags($request);

        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $uid = uniqid();

            $image = $request->file('cover_image');
            Image::make($image)->resize(128, 128) > encode('jpg')->save('images/' . $uid . '.jpg');

            $publication->cover_image = $uid;
            $publication->save();
        }

        event(new PublicationUpdated($publication));

        return response()->json($publication);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Publication $publication)
    {
        $title = $publication->title;

        $publication->delete();

        return response('Publication ' . $title . ' deleted');
    }
}
