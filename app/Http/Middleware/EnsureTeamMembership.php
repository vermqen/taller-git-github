<?php

namespace App\Http\Middleware;

use App\Models\Team;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTeamMembership
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Obtener la variable de la ruta (sea string slug o modelo Team)
        $teamParam = $request->route('current_team') ?? $request->route('team');

        if (! $teamParam) {
            return $next($request);
        }

        $slug = $teamParam instanceof Team ? $teamParam->getRouteKey() : (string) $teamParam;

        // Verificar pertenencia (soporta Jetstream allTeams() o relación teams())
        $teams = method_exists($user, 'allTeams') ? $user->allTeams() : $user->teams;

        $belongsToTeam = $teams->contains(function ($team) use ($slug) {
            return $team->slug === $slug || (string) $team->id === (string) $slug;
        });

        if (! $belongsToTeam) {
            // Si el usuario no pertenece a este equipo pero tiene uno activo, lo redirige al suyo
            if ($user->currentTeam) {
                return redirect()->route('dashboard', ['current_team' => $user->currentTeam->slug]);
            }

            // Si no tiene equipo asignado, lo manda a la vista de selección/creación de equipos
            return redirect()->route('teams.index');
        }

        return $next($request);
    }
}
