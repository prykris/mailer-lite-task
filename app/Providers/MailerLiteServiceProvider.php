<?php

namespace App\Providers;

use App\Services\MailerLiteService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;

class MailerLiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Session::put(
            'mailer_lite_api_key',
            'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI0IiwianRpIjoiNTEzYjJlODYzMzExZjExMmUzMzRmM2YwNzcwNDMzNjYwYzE1YTFkYmNjNGY1MDEyNzc1NzI4ZjkwZDU4MDczMTM3YjdkMTQ0MjNiODUyYjQiLCJpYXQiOjE2ODAxMTM2MjIuNDI3MDI5LCJuYmYiOjE2ODAxMTM2MjIuNDI3MDMxLCJleHAiOjQ4MzU3ODcyMjIuNDIxNjc2LCJzdWIiOiI0MTIzNDQiLCJzY29wZXMiOltdfQ.juhispIeCusOQln8ueIzEWIopOoWkZFCfwLEKRCD-m60qyxVZQXyb_3w54tq992m_MAhFP2foCOqRY3_DvAlj3yTpyGhF4xp_imoQYSFJVUQS1U0uvM7pnGGJ9W3sL-MAvSHt4TCnR1ulv4LXZZQA2XabL5NQgj9rKQ6R2J3MKh6DyG1-KrAU7O54K2KcYW2ikCOFy6Yh1CCMGHdYq1dWhyf2oElkYQuEWop-NpvNr44Hg-pCg9vnXmBNtJi1gi_U28hpp38yolMOkQBYK5zk7yt60GciZhVa2Tlk2XeTSjU8c1TysbGOCiyFIQuUJZnRiud5kaNhEQ5b39b--RVzt4oAcX2aSuqZo1W2j9s37RIf4BHNhju_-Oa6kPo2_fcZJnXfwPlkvkisQ2yAZ3j5dTIDRNK8Qr410g32lvxBjeM97uz7qIluoB7txfj856lIAwS_NIPoqglCN0Wdw66LPf1DGmUZByfzuc3AybPvFYnUh55RVkTyLpRKbqw_qIuxV3GSpnuF42-dkaaql3dI0AeM6sNHY0KyWxGeDdibhYu6NVPuxoo_RV_wHaJz0t6wxUHDe3ZuRUpqgoDOsuCJ8hP029GFknZQph-3j6-VRrwv0GvOKS5O2TGZgFMR0bOdgOW0yIPJmVh-e6Dt1Wo_WBjt90qcEGsnStZP7YO52E'
        );

        $this->app->bind(MailerLiteService::class, function (): ?MailerLiteService {
            $apiKey = Session::get('mailer_lite_api_key');

            if ($apiKey) {
                return new MailerLiteService($apiKey);
            }

            return null;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
