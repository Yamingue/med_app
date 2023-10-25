<?php

namespace App\Twig\Runtime;

use App\Repository\ConsultationRepository;
use App\Repository\ExamentRepository;
use App\Repository\PatientRepository;
use App\Repository\UserRepository;
use Twig\Extension\RuntimeExtensionInterface;

class StateRuntime implements RuntimeExtensionInterface
{
    public function __construct(
        private UserRepository $userRepository,
        private PatientRepository $patientRepository,
        private ConsultationRepository $consultationRepository,
        private ExamentRepository $examentRepository,
    ) {
        // Inject dependencies if needed
    }

    public function countUser()
    {
        return count($this->userRepository->findAll());
    }

    public function countPatient()
    {
        return count($this->patientRepository->findAll());
    }

    public function countConsultation()
    {
        return count($this->consultationRepository->findAll());
    }

    public function countExamens()
    {
        return count($this->examentRepository->findAll());
    }

    public function cosultationTodayAmount()
    {
        $exams = $this->consultationRepository->findByDate(new \DateTime());
        $total = 0;
        foreach ($exams as $ex) {
            $total += $ex->getPrix();
        }
        return $total;
    }


    public function cosultationLastWeekAmount()
    {
        $date2 = new \DateTime();
        $date2->modify("-7 day");
        $exams = $this->consultationRepository->findBetweenDate(new \DateTime(), $date2);
        $total = 0;
        foreach ($exams as $ex) {
            $total += $ex->getPrix();
        }
        return $total;
    }

    public function cosultationLastMouthAmount()
    {
        $date2 = new \DateTime();
        $date2->modify("-30 day");
        $exams = $this->consultationRepository->findBetweenDate(new \DateTime(), $date2);
        $total = 0;
        foreach ($exams as $ex) {
            $total += $ex->getPrix();
        }
        return $total;
    }

    public function examensTodayAmount()
    {
        $exams = $this->examentRepository->findByDate(new \DateTime());
        $total = 0;
        foreach ($exams as $ex) {
            $total += $ex->getAmount();
        }
        return $total;
    }

    public function examensLastWeekAmount()
    {
        $date2 = new \DateTime();
        $date2->modify("-7 day");
        $exams = $this->examentRepository->findBetweenDate(new \DateTime(), $date2);
        $total = 0;
        foreach ($exams as $ex) {
            $total += $ex->getAmount();
        }
        return $total;
    }

    public function examensLastMountAmount()
    {
        $date2 = new \DateTime();
        $date2->modify("-30 day");
        $exams = $this->examentRepository->findBetweenDate(new \DateTime(), $date2);
        $total = 0;
        foreach ($exams as $ex) {
            $total += $ex->getAmount();
        }
        return $total;
    }
}
