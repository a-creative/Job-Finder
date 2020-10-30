<?php

namespace App\Http\Controllers;

use App\Entities\JobExperience;
use App\Entities\User;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Illuminate\Http\Request;

class JobExperienceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function index()
    {
        $jobExperiences = EntityManager::createQueryBuilder()
            ->select('je')
            ->from(JobExperience::class, 'je')
            ->where('je.ownerUser = :user')
            ->setParameter('user', auth()->user())
            ->getQuery()
            ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY)
        ;

        return $jobExperiences;
    }

    private static function assignFromRequest( Request $request, JobExperience $jobExperience, bool $isInsert = false ) : JobExperience {

        // Update user controlled
        $jobExperience->setJobTitle( $request->jobTitle );
        $jobExperience->setEmployer( $request->input('employer' ) );

        if ( $request->has('startedDate')) {
            $jobExperience->setStartedDate( new \DateTime($request->input('startedDate')));
        } else {
            $jobExperience->setStartedDate( null );
        }

        if ( $request->has('endedDate')) {
            $jobExperience->setEndedDate( new \DateTime($request->input('endedDate')));
        } else {
            $jobExperience->setEndedDate( null );
        }

        $now = new \DateTime();

        // Update system controlled
        if ( $isInsert ) {
            $jobExperience->setCreatedTime( $now );
        }
        $jobExperience->setUpdatedTime( $now );

        return $jobExperience;
    }

    public function insert(Request $request ) {
        $jobExperience = new JobExperience();
        $jobExperience->setOwnerUser( auth()->user() );
        $jobExperience = static::assignFromRequest( $request, $jobExperience, true );
        EntityManager::persist( $jobExperience);
        EntityManager::flush();

        return response()->json($jobExperience->toArray());
    }

    public function update(Request $request, int $id) {
        $jobExperience = EntityManager::find( JobExperience::class, $id );

        /** @var User $authUser */
        $authUser = auth()->user();

        /** @var JobExperience $jobExperience */
        if ( $jobExperience->getOwnerUser()->getId() === $authUser->getId() ) {

            $jobExperience = static::assignFromRequest( $request, $jobExperience );
            EntityManager::persist( $jobExperience );
            EntityManager::flush();

            return response()->json($jobExperience->toArray());

        }
        
    }

    public function delete(Request $request, int $id) {

        /** @var User $authUser */
        $authUser = auth()->user();

        /** @var JobExperience $jobExperience */
        $jobExperience = EntityManager::find( JobExperience::class, $id );

        if ($jobExperience->getOwnerUser()->getId() === $authUser->getId()) {
            EntityManager::remove($jobExperience);
            EntityManager::flush();
            return $id;
        }
    }
}