<?php

namespace App\Http\Controllers;

use App\Entities\JobPosting;
use App\Entities\User;
use LaravelDoctrine\ORM\Facades\EntityManager;
use Illuminate\Http\Request;

class JobPostingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => []]);
    }

    public function index()
    {
        $result = EntityManager::createQueryBuilder()
            ->select('jp')
            ->from(JobPosting::class, 'jp')
            ->where('jp.ownerUser = :user')
            ->setParameter('user', auth()->user())
            ->getQuery()
            ->getResult(\Doctrine\ORM\AbstractQuery::HYDRATE_ARRAY)
        ;

        return [
            'posting' => ['postings' => $result],
        ];
    }

    private static function assignFromRequest( Request $request, JobPosting $jobPosting, bool $isInsert = false ) : JobPosting {

        // Update user controlled
        $jobPosting->setJobTitle( $request->jobTitle );
        $jobPosting->setEmployer( $request->input('employer' ) );
        $jobPosting->setExtLink( $request->input('extLink' ) );

        if ( $request->has('postedDate')) {
            $jobPosting->setPostedDate( new \DateTime($request->input('postedDate')));
        } else {
            $jobPosting->setPostedDate( null );
        }

        if ( $request->has('deadlineDate')) {
            $jobPosting->setDeadlineDate( new \DateTime($request->input('deadlineDate')));
        } else {
            $jobPosting->setDeadlineDate( null );
        }

        $jobPosting->setLocationCity( $request->input('locationCity' ) );
        $jobPosting->setLocationPostalCode( $request->input('locationPostalCode' ) );
        $jobPosting->setContactName( $request->input('contactName' ) );
        $jobPosting->setContactJobTitle( $request->input('contactJobTitle' ) );
        $jobPosting->setContactDetails( $request->input('contactDetails' ) );
        $jobPosting->setContentRaw( $request->input('contentRaw' ) );

        $now = new \DateTime();

        // Update system controlled
        if ( $isInsert ) {
            $jobPosting->setCreatedTime( $now );
        }
        $jobPosting->setUpdatedTime( $now );

        return $jobPosting;
    }

    public function insert(Request $request ) {
        $jobPosting = new JobPosting();
        $jobPosting = static::assignFromRequest( $request, $jobPosting, true );
        EntityManager::persist( $jobPosting);
        EntityManager::flush();

        return response()->json([
            "posting" => $jobPosting->toArray()
        ]);
    }

    public function update(Request $request, int $id) {
        $jobPosting = EntityManager::find( JobPosting::class, $id );
        $jobPosting = static::assignFromRequest( $request, $jobPosting );
        EntityManager::persist( $jobPosting );
        EntityManager::flush();

        return response()->json([
            "posting" => $jobPosting->toArray()
        ]);
    }

    public function delete(Request $request, int $id) {
        $jobPosting = EntityManager::find( JobPosting::class, $id );
        EntityManager::remove( $jobPosting );
        EntityManager::flush();
        return $id;
    }
}
