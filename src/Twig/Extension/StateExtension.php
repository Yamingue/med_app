<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\StateRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class StateExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('count_user', [StateRuntime::class, 'countUser']),
            new TwigFilter('count_patient', [StateRuntime::class, 'countPatient']),
            new TwigFilter('count_consultation', [StateRuntime::class, 'countConsultation']),
            new TwigFilter('count_examens', [StateRuntime::class, 'countExamens']),
            new TwigFilter('cosultation_today_amount', [StateRuntime::class, 'cosultationTodayAmount']),
            new TwigFilter('examens_today_amount', [StateRuntime::class, 'examensTodayAmount']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('count_user', [StateRuntime::class, 'countUser']),
            new TwigFunction('count_patient', [StateRuntime::class, 'countPatient']),
            new TwigFunction('count_consultation', [StateRuntime::class, 'countConsultation']),
            new TwigFunction('count_examens', [StateRuntime::class, 'countExamens']),
            new TwigFunction('cosultation_today_amount', [StateRuntime::class, 'cosultationTodayAmount']),
            new TwigFunction('cosultation_last_week_amount', [StateRuntime::class, 'cosultationLastWeekAmount']),
            new TwigFunction('cosultation_last_mouth_amount', [StateRuntime::class, 'cosultationLastMouthAmount']),

            new TwigFunction('examens_today_amount', [StateRuntime::class, 'examensTodayAmount']),
            new TwigFunction('examens_last_week_amount', [StateRuntime::class, 'examensLastWeekAmount']),
            new TwigFunction('examens_last_mount_amount', [StateRuntime::class, 'examensLastMountAmount']),
        ];
    }
}
