<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Traits\FindsModels;
use App\Services\UrlCheckService;

class ProjectController extends Controller
{
    use FindsModels;

    public function index()
    {
        $query = Project::query();

        $projects = $query->paginate(request('limit', 10));

        return ProjectResource::collection($projects);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->validated());
        return (new ProjectResource($project))
               ->response()
               ->setStatusCode(201);
    }

    public function show($id)
    {
        $project = $this->findOrFailCustom(Project::class, $id);
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $project = $this->findOrFailCustom(Project::class, $id);
        $project->update($request->validated());
        $project->refresh();
        return new ProjectResource($project);
    }

    public function destroy($id)
    {
        $project = $this->findOrFailCustom(Project::class, $id);
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully.'], 204);
    }

    // Доп. задание — проверка доступности сайта
    public function check($id, UrlCheckService $service)
    {
        $project = $this->findOrFailCustom(Project::class, $id);
        $result = $service->check($project->url);
        return response()->json($result);
    }
}
