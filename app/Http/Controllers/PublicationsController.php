<?php

namespace LoremPublishing\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;
use LoremPublishing\Publication;
use LoremPublishing\Tag;

class PublicationsController extends Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $publications = Publication::orderBy('created_at', 'desc')->paginate(10);

        return view('admin.publications.index', compact('publications'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tags = Tag::pluck('title', 'id')->all();

        return view('admin.publications.create', compact('tags'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'text' => 'required|min:10',
            'cover_image' => 'mimes:png,jpeg,jpg,bmp',
        ]);

        $publication = Auth::user()->publications()->create($request->all());

        $publication->syncTags($request);

        if (Input::hasFile('cover_image') && Input::file('cover_image')->isValid()) {
            $uid = uniqid();

            Image::make(Input::file('cover_image'))->resize(128, 128)->encode('jpg')->save('images/' . $uid . '.jpg');

            $publication->cover_image = $uid;
            $publication->save();
        }


        return redirect()->route('publications.index');
    }


    /**
     * @param Publication $publication
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Publication $publication)
    {
        $tags = Tag::pluck('title', 'id')->all();

        return view('admin.publications.edit', compact('publication', 'tags'));
    }


    /**
     * @param Request $request
     * @param Publication $publication
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Publication $publication)
    {
        $this->validate($request, [
            'title' => 'required|min:3|max:255',
            'text' => 'required|min:10',
            'cover_image' => 'mimes:png,jpeg,jpg,bmp',
        ]);

        $publication->update($request->all());

        $publication->syncTags($request);

        if (Input::hasFile('cover_image') && Input::file('cover_image')->isValid()) {
            $uid = uniqid();

            Image::make(Input::file('cover_image'))->resize(128, 128)->encode('jpg')->save('images/' . $uid . '.jpg');

            $publication->cover_image = $uid;
            $publication->save();
        }


        return redirect()->route('publications.index');
    }


    /**
     * @param Publication $publication
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Publication $publication)
    {
        $publication->delete();

        return redirect()->route('publications.index');
    }
}
