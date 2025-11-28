<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = auth()->user()->ownedProjects()->get();
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'naziv_projekta' => 'required|string|max:255',
            'opis_projekta' => 'nullable|string',
            'cijena_projekta' => 'nullable|numeric',
            'obavljeni_poslovi' => 'nullable|string',
            'datum_pocetka' => 'nullable|date',
            'datum_zavrsetka' => 'nullable|date',
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        $data['user_id'] = auth()->id();

        $project = Project::create($data);
        if (!empty($data['members'])) {
            $project->members()->sync($data['members']);
        }

        return redirect()->route('projects.edit', $project)->with('success', 'Projekt kreiran.');
    }

    public function edit(Project $project)
    {
        $users = User::where('id', '!=', auth()->id())->get();
        return view('projects.edit', compact('project','users'));
    }

    public function update(Request $request, Project $project)
    {
        if ($project->user_id == auth()->id()) {
            $data = $request->validate([
                'naziv_projekta' => 'required|string|max:255',
                'opis_projekta' => 'nullable|string',
                'cijena_projekta' => 'nullable|numeric',
                'obavljeni_poslovi' => 'nullable|string',
                'datum_pocetka' => 'nullable|date',
                'datum_zavrsetka' => 'nullable|date',
            ]);
        } else {
            if (!$project->members->contains(auth()->id())) {
                abort(403, 'Nemaš pristup ovom projektu.');
            }
            $data = $request->validate([
                'obavljeni_poslovi' => 'required|string',
            ]);
        }

        $project->update($data);

        return redirect()->route('projects.edit', $project)->with('success', 'Projekt ažuriran.');
    }

    public function addMember(Request $request, Project $project)
    {
        if ($project->user_id != auth()->id()) {
            abort(403, 'Samo voditelj može dodavati članove.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $project->members()->syncWithoutDetaching($request->user_id);

        return back()->with('success', 'Član dodan.');
    }
}
