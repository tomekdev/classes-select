<?php

namespace App\Http\Controllers\Student;

use App\StudentHasSubject;
use App\SubSubject;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $student = Auth::guard('student')->user();
        $subjects = [];
        $currentDate = Carbon::now()->setTimezone('Europe/Warsaw');
        $studentTerms = $student->getConnectedTerms();
        $studentTermsCount = count($studentTerms);
        
        $subjects = [];
        
        if ($studentTerms) {
            foreach ($studentTerms as $study => $terms) {
                foreach ($terms as $term) {
                    if ($term->active) {
                        $termSubjects = $student->getSubjectFromTerm($term);
                        foreach ($termSubjects as $subject) {
                            if (isset($subjects[$subject->id]) && $subjects[$subject->id]['selectable']) { //jest wcześniejszy termin dla tych studiów
                                $subjects[$subject->id]['alternatives'][] = [
                                    'start_date' => Carbon::parse($term->start_date)->format("Y-m-d"),
                                    'start_time' => Carbon::parse($term->start_date)->format("H:i"),
                                    'finish_date' => Carbon::parse($term->finish_date)->format("Y-m-d"),
                                    'finish_time' => Carbon::parse($term->finish_date)->format("H:i")
                                ];
                            }
                            else {
                                $isActive = false;
                                foreach ($subject->getSubSubjects() ? $subject->getSubSubjects() : [] as $subSubject){
                                    if($subSubject->active){
                                        $isActive = true;
                                        break;
                                    }
                                }
                                if(!$isActive)
                                    continue;
                                $subjectData = [];
                                $subjectData['selected'] = false;
                                $subjectData['selectable'] = true;
                                $subjectData['active'] = true;
                                $subjectData['id'] = $subject->id;
                                $subjectData['name'] = $subject->name;
                                $subjectData['faculty'] = $subject->getFaculty()->name;
                                $subjectData['field'] = $subject->getField()->name;
                                $subjectData['semester'] = $subject->getSemester()->name;
                                $subjectData['degree'] = $subject->getDegree()->name;
                                $subjectData['study_form'] = $subject->getStudyForm()->name;

                                foreach ($student->getSelectedSubjects() as $selectedSubject)
                                    if ($selectedSubject['subject']->id == $subject->id) {
                                        $subjectData['selected'] = true;
                                        $subjectData['subSubject']['id'] = $selectedSubject['subSubject']->id;
                                        $subjectData['subSubject']['name'] = $selectedSubject['subSubject']->name;
                                        break;
                                    }

                                if ($term->start_date > $currentDate) {
                                    $subjectData['active'] = false;
                                    $subjectData['start_date'] = Carbon::parse($term->start_date)->format("Y-m-d");
                                    $subjectData['start_time'] = Carbon::parse($term->start_date)->format("H:i");
                                }

                                if ($term->finish_date > $currentDate) {
                                    foreach ($subject->getSubSubjects() as $key2 => $subSubject) {
                                        $numberOfChoosedSubSubject = count(StudentHasSubject::where('subSubject_id', $subSubject->id)->get());
                                        $subjectData['subSubjects'][$key2]['name'] = $subSubject->name;
                                        $subjectData['subSubjects'][$key2]['id'] = $subSubject->id;
                                        $subjectData['subSubjects'][$key2]['active'] = $numberOfChoosedSubSubject >= $subSubject->max_person ? false : true;
                                        $subjectData['subSubjects'][$key2]['selectedCount'] =$numberOfChoosedSubSubject;
                                        $subjectData['subSubjects'][$key2]['max_person'] = $subSubject->max_person;

                                    }
                                    $subjectData['finish_date'] = Carbon::parse($term->finish_date)->format("Y-m-d");
                                    $subjectData['finish_time'] = Carbon::parse($term->finish_date)->format("H:i");
                                } else {
                                    $subjectData['selectable'] = false;
                                }
                                $subjects[$subject->id] = $subjectData;
                            }
                        }
                    }
                }
            }
        }

//        if(isset($studentTerms[0]))
//            foreach ($studentTerms as $key => $terms) {
//            foreach ($terms as $term) {
//                if($term->active) {
//                    $termSubjects = $student->getSubjectFromTerm($term);
//                    foreach ($termSubjects as $key1 => $termSubject) {
//                        $i = $key * $studentTermsCount + $key1;
//                        $subjects[$i]['subject']['selected'] = false;
//                        $subjects[$i]['subject']['selectable'] = true;
//                        $subjects[$i]['subject']['active'] = true;
//                        $subjects[$i]['subject']['id'] = $termSubject->id;
//                        $subjects[$i]['subject']['name'] = $termSubject->name;
//                        $subjects[$i]['subject']['faculty'] = $termSubject->getFaculty()->name;
//                        $subjects[$i]['subject']['field'] = $termSubject->getField()->name;
//                        $subjects[$i]['subject']['semester'] = $termSubject->getSemester()->name;
//                        $subjects[$i]['subject']['degree'] = $termSubject->getDegree()->name;
//                        $subjects[$i]['subject']['study_form'] = $termSubject->getStudyForm()->name;
//
//                        foreach ($student->getSelectedSubjects() as $selectedSubject)
//                            if ($selectedSubject['subject']->id == $termSubject->id) {
//                                $subjects[$i]['subject']['selected'] = true;
//                                $subjects[$i]['subSubject']['id'] = $selectedSubject['subSubject']->id;
//                                $subjects[$i]['subSubject']['name'] = $selectedSubject['subSubject']->name;
//                                break;
//                            }
//
//                        if ($term->start_date > $currentDate) {
//                            $subjects[$i]['subject']['active'] = false;
//                            $subjects[$i]['subject']['start_date'] = Carbon::parse($term->start_date)->format("Y-m-d");
//                            $subjects[$i]['subject']['start_time'] = Carbon::parse($term->start_date)->format("H:i");
//                        }
//
//                        if ($term->finish_date > $currentDate) {
//                            foreach ($termSubject->getSubSubjects() as $key2 => $subSubject) {
//                                $numberOfChoosedSubSubject = $subSubject->current_person;
//                                $subjects[$i]['subSubjects'][$key2]['name'] = $subSubject->name;
//                                $subjects[$i]['subSubjects'][$key2]['id'] = $subSubject->id;
//                                $subjects[$i]['subSubjects'][$key2]['active'] = $numberOfChoosedSubSubject >= $subSubject->max_person ? false : true;
//                                $subjects[$i]['subSubjects'][$key2]['selectedCount'] =$numberOfChoosedSubSubject;
//                                $subjects[$i]['subSubjects'][$key2]['max_person'] = $subSubject->max_person;
//
//                            }
//                            $subjects[$i]['subject']['finish_date'] = Carbon::parse($term->finish_date)->format("Y-m-d");
//                            $subjects[$i]['subject']['finish_time'] = Carbon::parse($term->finish_date)->format("H:i");
//                        } else {
//                            $subjects[$i]['subject']['selectable'] = false;
//                        }
//                    }
//                }
//            }
//        }
        return view('student.selectableSubject')->with(['subjects' => $subjects, 'student_id' => $student->id]);
    }
}
