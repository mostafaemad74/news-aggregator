<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use App\Models\Article;

class ArticleController extends Controller
{


    /**
     * Display a paginated list of articles.
     *
     * This method retrieves all articles from the database, orders them
     * by their published date in descending order, and returns a paginated
     * collection of articles wrapped in an ArticleResource. The pagination
     * count can be specified via the 'per_page' query parameter, defaulting
     * to 10 if not provided.
     *
     * @param Request $request
     * @return ArticleResource
     */
    public function index(Request $request)
    {
        $articles = Article::query()
            ->orderBy('published_at', 'desc')
            ->paginate($request->per_page ?? 10);

        return ArticleResource::collection($articles);
    }



    /**
     * Search for articles based on various filters.
     *
     * This method allows searching for articles by category, source, author,
     * keyword, and date range. It returns a paginated collection of articles
     * ordered by the published date in descending order.
     *
     * @param Request $request
     * @return ArticleResource
     */
    public function search(Request $request)
    {
        $query = Article::query();

        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('source')) {
            $query->where('source', $request->source);
        }

        if ($request->has('author')) {
            $query->where('author', 'like', '%' . $request->author . '%');
        }

        if ($request->has('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->keyword . '%')
                    ->orWhere('description', 'like', '%' . $request->keyword . '%')
                    ->orWhere('content', 'like', '%' . $request->keyword . '%');
            });
        }

        if ($request->has(['start_date', 'end_date'])) {
            $query->whereBetween('published_at', [
                $request->start_date,
                $request->end_date,
            ]);
        }


        $articles = $query->orderBy('published_at', 'desc')->paginate($request->per_page ?? 10);

        return ArticleResource::collection($articles);
    }
}
