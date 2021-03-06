<div class="container">
    <div class="row">
        <div class="col s12 m6 l3 padding-v-2">
            <div class="column-caption">Разделы</div>
            <ul>
                <li><a href="{{ route('category.show', ['category' => 'auto']) }}">Авто</a></li>
                <li><a href="{{ route('category.show', ['category' => 'moto']) }}">Мото</a></li>
                <li><a href="{{ route('category.show', ['category' => 'law']) }}">Право</a></li>
                <li><a href="{{ route('category.show', ['category' => 'helpful']) }}">Полезное</a></li>
            </ul>
        </div>
        <div class="col s12 m6 l3 padding-v-2 col-last-m">
            <div class="column-caption">Информация</div>
            <ul>
                <li><a href="{{ route('page.about') }}">О сайте</a></li>
                <li><a href="{{ route('page.rules') }}">Правила</a></li>
            </ul>
        </div>
        <div class="col s12 m6 l3 padding-v-2">
            <div class="column-caption">Лучшие статьи</div>
            <ul>
                <li><a href="{{ route('posts.rated') }}">по рейтингу</a></li>
                <li><a href="{{ route('posts.views') }}">по просмотрам</a></li>
                <li><a href="{{ route('posts.comments') }}">по комментариям</a></li>
            </ul>
        </div>
        <div class="col s12 m6 l3 padding-v-2">
            <div class="column-caption">Мы в соцсетях</div>
            <a href="https://vk.com/driveitwithme" target="_blank" rel="noopener noreferrer nofollow" class="outer-container">
                <div class="first-inner-container">
                    <svg version="1.1" class="vk-btn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 14.171 14.171" style="enable-background:new 0 0 14.171 14.171;" xml:space="preserve">
                        <g>
                            <path d="M13.268,0H0.905C0.405,0,0,0.405,0,0.904v12.363c0,0.499,0.405,0.904,0.905,0.904h12.362
                            c0.499,0,0.904-0.405,0.904-0.904V0.904C14.172,0.404,13.767,0,13.268,0z M11.755,8.635c0.259,0.264,0.821,0.707,0.719,1.158
                            c-0.094,0.414-0.712,0.263-1.312,0.287c-0.685,0.029-1.091,0.044-1.503-0.287C9.465,9.636,9.351,9.45,9.165,9.242
                            C8.996,9.054,8.783,8.717,8.493,8.73C7.972,8.756,8.135,9.482,7.95,9.977c-2.896,0.456-4.059-1.333-5.085-3.069
                            C2.368,6.067,1.65,4.261,1.65,4.261l2.048-0.007c0,0,0.657,1.195,0.831,1.503c0.148,0.262,0.311,0.47,0.479,0.704
                            c0.141,0.194,0.364,0.574,0.608,0.543c0.397-0.051,0.469-1.591,0.223-2.107C5.741,4.688,5.506,4.615,5.263,4.544
                            C5.345,4.026,7.56,3.918,7.918,4.32c0.52,0.584-0.36,2.21,0.352,2.684c1-0.524,1.854-2.718,1.854-2.718l2.398,0.015
                            c0,0-0.375,1.186-0.768,1.712c-0.229,0.308-0.989,0.994-0.959,1.503C10.819,7.919,11.437,8.311,11.755,8.635z"></path>
                        </g>
                    </svg>
                </div>
                <div class="second-inner-container">ВКонтакте</div>
            </a>
            <a href="https://www.facebook.com/groups/745210485639351" target="_blank" rel="noopener noreferrer nofollow" class="outer-container">
                <div class="first-inner-container">
                <svg version="1.1" class="facebook-btn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 90 90" style="enable-background:new 0 0 90 90;" xml:space="preserve">
                    <g>
                        <path d="M90,15.001C90,7.119,82.884,0,75,0H15C7.116,0,0,7.119,0,15.001v59.998
                        C0,82.881,7.116,90,15.001,90H45V56H34V41h11v-5.844C45,25.077,52.568,16,61.875,16H74v15H61.875C60.548,31,59,32.611,59,35.024V41
                        h15v15H59v34h16c7.884,0,15-7.119,15-15.001V15.001z"></path>
                    </g>
                </svg>
                </div>
                <div class="second-inner-container">Facebook</div>
            </a>
            <a href="https://twitter.com/driveitwithme" target="_blank" rel="noopener noreferrer nofollow" class="outer-container">
                <div class="first-inner-container">
                    <svg version="1.1" class="twitter-btn" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 486.392 486.392" style="enable-background:new 0 0 486.392 486.392;" xml:space="preserve">
                        <g>
                            <path d="M395.193,0H91.198C40.826,0,0,40.826,0,91.198v303.995c0,50.372,40.826,91.198,91.198,91.198
                            h303.995c50.372,0,91.198-40.827,91.198-91.198V91.198C486.392,40.826,445.565,0,395.193,0z M364.186,188.598l0.182,7.752
                            c0,79.16-60.221,170.359-170.359,170.359c-33.804,0-65.268-9.91-91.776-26.904c4.682,0.547,9.454,0.851,14.288,0.851
                            c28.059,0,53.868-9.576,74.357-25.627c-26.204-0.486-48.305-17.814-55.935-41.586c3.678,0.669,7.387,1.034,11.278,1.034
                            c5.472,0,10.761-0.699,15.777-2.067c-27.39-5.533-48.031-29.7-48.031-58.701v-0.76c8.086,4.499,17.297,7.174,27.116,7.509
                            c-16.051-10.731-26.63-29.062-26.63-49.825c0-10.974,2.949-21.249,8.086-30.095c29.518,36.236,73.658,60.069,123.422,62.562
                            c-1.034-4.378-1.55-8.968-1.55-13.649c0-33.044,26.812-59.857,59.887-59.857c17.206,0,32.771,7.265,43.714,18.908
                            c13.619-2.706,26.448-7.691,38.03-14.531c-4.469,13.984-13.953,25.718-26.326,33.135c12.069-1.429,23.651-4.682,34.382-9.424
                            C386.073,169.659,375.889,180.208,364.186,188.598z"></path>
                        </g>
                    </svg>
                </div>
                <div class="second-inner-container">Twitter</div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <div class="copyright flex flex-v-center flex-h-center-all">
                <svg version="1.1" class="copyright-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 16 16">
                    <path d="M8 1.5c3.6 0 6.5 2.9 6.5 6.5s-2.9 6.5-6.5 6.5-6.5-2.9-6.5-6.5 2.9-6.5 6.5-6.5zM8 0c-4.4 0-8 3.6-8 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8v0z"></path>
                    <path d="M9.9 10.3c-0.5 0.4-1.2 0.7-1.9 0.7-1.7 0-3-1.3-3-3s1.3-3 3-3c0.8 0 1.6 0.3 2.1 0.9l1.1-1.1c-0.8-0.8-2-1.3-3.2-1.3-2.5 0-4.5 2-4.5 4.5s2 4.5 4.5 4.5c1.1 0 2-0.4 2.8-1l-0.9-1.2z"></path>
                </svg>
                <p>{{ \Illuminate\Support\Carbon::now()->year }} - {{config('drive.APP_NAME')}}. Все права защищены.</p>
            </div>
        </div>
    </div>
</div>