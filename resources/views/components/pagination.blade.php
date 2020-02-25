@if ($items->hasPages())
    <div class="pagination-wrapper flex flex-h-center-all">
        <ul class="pagination">
            @if ($items->currentPage() - $items_to_display > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ config('app.url').$paginated_route }}">
                        <svg version="1.1" class="chevron-left-double" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="284.929px" height="284.929px" viewBox="0 0 284.929 284.929" style="enable-background:new 0 0 284.929 284.929;"
                        xml:space="preserve">
                            <g>
                                <path d="M165.304,142.468L277.517,30.267c1.902-1.903,2.847-4.093,2.847-6.567c0-2.475-0.951-4.665-2.847-6.567L263.239,2.857
                                C261.337,0.955,259.146,0,256.676,0c-2.478,0-4.665,0.955-6.571,2.857L117.057,135.9c-1.903,1.903-2.853,4.093-2.853,6.567
                                c0,2.475,0.95,4.664,2.853,6.567l133.048,133.043c1.903,1.906,4.086,2.851,6.564,2.851c2.478,0,4.66-0.947,6.563-2.851
                                l14.277-14.267c1.902-1.903,2.851-4.094,2.851-6.57c0-2.472-0.948-4.661-2.851-6.564L165.304,142.468z"/>
                                <path d="M55.668,142.468L167.87,30.267c1.903-1.903,2.851-4.093,2.851-6.567c0-2.475-0.947-4.665-2.851-6.567L153.6,2.857
                                C151.697,0.955,149.507,0,147.036,0c-2.478,0-4.668,0.955-6.57,2.857L7.417,135.9c-1.903,1.903-2.853,4.093-2.853,6.567
                                c0,2.475,0.95,4.664,2.853,6.567l133.048,133.043c1.902,1.906,4.09,2.851,6.57,2.851c2.471,0,4.661-0.947,6.563-2.851
                                l14.271-14.267c1.903-1.903,2.851-4.094,2.851-6.57c0-2.472-0.947-4.661-2.851-6.564L55.668,142.468z"/>
                            </g>
                        </svg>
                    </a>
                </li>
            @endif
            @if ($items->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true">
                        <svg version="1.1" class="chevron-left" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="444.531px" height="444.531px" viewBox="0 0 444.531 444.531" style="enable-background:new 0 0 444.531 444.531;"
                             xml:space="preserve">
                            <g>
                                <path d="M213.13,222.409L351.88,83.653c7.05-7.043,10.567-15.657,10.567-25.841c0-10.183-3.518-18.793-10.567-25.835
                                l-21.409-21.416C323.432,3.521,314.817,0,304.637,0s-18.791,3.521-25.841,10.561L92.649,196.425
                                c-7.044,7.043-10.566,15.656-10.566,25.841s3.521,18.791,10.566,25.837l186.146,185.864c7.05,7.043,15.66,10.564,25.841,10.564
                                s18.795-3.521,25.834-10.564l21.409-21.412c7.05-7.039,10.567-15.604,10.567-25.697c0-10.085-3.518-18.746-10.567-25.978
                                L213.13,222.409z"/>
                            </g>
                        </svg>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ config('app.url').$paginated_route.'/page/'. $previousNumberPage }}" rel="prev" aria-label="@lang('pagination.previous')">
                        <svg version="1.1" class="chevron-left" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="444.531px" height="444.531px" viewBox="0 0 444.531 444.531" style="enable-background:new 0 0 444.531 444.531;"
                        xml:space="preserve">
                            <g>
                                <path d="M213.13,222.409L351.88,83.653c7.05-7.043,10.567-15.657,10.567-25.841c0-10.183-3.518-18.793-10.567-25.835
                                l-21.409-21.416C323.432,3.521,314.817,0,304.637,0s-18.791,3.521-25.841,10.561L92.649,196.425
                                c-7.044,7.043-10.566,15.656-10.566,25.841s3.521,18.791,10.566,25.837l186.146,185.864c7.05,7.043,15.66,10.564,25.841,10.564
                                s18.795-3.521,25.834-10.564l21.409-21.412c7.05-7.039,10.567-15.604,10.567-25.697c0-10.085-3.518-18.746-10.567-25.978
                                L213.13,222.409z"/>
                            </g>
                        </svg>
                    </a>
                </li>
            @endif
            @if ($items->currentPage() - $items_to_display > 1)
                <li class="page-item">
                    <span class="page-link">
                        <svg class="elepsis-svg" enable-background="new 0 0 515.555 515.555" height="512" viewBox="0 0 515.555 515.555" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m496.679 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/><path d="m303.347 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/><path d="m110.014 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/></svg>
                    </span>
                </li>
            @endif
            @for ($i = $items->currentPage() - $items_to_display; $i <= $items->currentPage() + $items_to_display; $i++)
                @if ($i >= 1 and $i <= $lastNumberPage)
                    @if ($i == $items->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $i }}</span></li>
                    @else
                        @if ($i == 1)
                            <li class="page-item"><a class="page-link" href="{{ config('app.url').$paginated_route }}">{{ $i }}</a></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ config('app.url').$paginated_route.'/page/'.$i }}">{{ $i }}</a></li>
                        @endif
                    @endif
                @endif
            @endfor
            @if ($items->currentPage() + $items_to_display < $lastNumberPage)
                <li class="page-item">
                    <span class="page-link">
                        <svg class="elepsis-svg" enable-background="new 0 0 515.555 515.555" height="512" viewBox="0 0 515.555 515.555" width="512" xmlns="http://www.w3.org/2000/svg"><path d="m496.679 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/><path d="m303.347 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/><path d="m110.014 212.208c25.167 25.167 25.167 65.971 0 91.138s-65.971 25.167-91.138 0-25.167-65.971 0-91.138 65.971-25.167 91.138 0"/></svg>
                    </span>
                </li>
            @endif
            @if ($items->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ config('app.url').$paginated_route.'/page/'. $nextNumberPage }}" rel="next" aria-label="@lang('pagination.next')">
                        <svg version="1.1" class="chevron-right" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="444.819px" height="444.819px" viewBox="0 0 444.819 444.819" style="enable-background:new 0 0 444.819 444.819;"
                        xml:space="preserve">
                            <g>
                                <path d="M352.025,196.712L165.884,10.848C159.029,3.615,150.469,0,140.187,0c-10.282,0-18.842,3.619-25.697,10.848L92.792,32.264
                                c-7.044,7.043-10.566,15.604-10.566,25.692c0,9.897,3.521,18.56,10.566,25.981l138.753,138.473L92.786,361.168
                                c-7.042,7.043-10.564,15.604-10.564,25.693c0,9.896,3.521,18.562,10.564,25.98l21.7,21.413
                                c7.043,7.043,15.612,10.564,25.697,10.564c10.089,0,18.656-3.521,25.697-10.564l186.145-185.864
                                c7.046-7.423,10.571-16.084,10.571-25.981C362.597,212.321,359.071,203.755,352.025,196.712z"/>
                            </g>
                        </svg>
                    </a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true">
                        <svg version="1.1" class="chevron-right" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                             width="444.819px" height="444.819px" viewBox="0 0 444.819 444.819" style="enable-background:new 0 0 444.819 444.819;"
                             xml:space="preserve">
                            <g>
                                <path d="M352.025,196.712L165.884,10.848C159.029,3.615,150.469,0,140.187,0c-10.282,0-18.842,3.619-25.697,10.848L92.792,32.264
                                c-7.044,7.043-10.566,15.604-10.566,25.692c0,9.897,3.521,18.56,10.566,25.981l138.753,138.473L92.786,361.168
                                c-7.042,7.043-10.564,15.604-10.564,25.693c0,9.896,3.521,18.562,10.564,25.98l21.7,21.413
                                c7.043,7.043,15.612,10.564,25.697,10.564c10.089,0,18.656-3.521,25.697-10.564l186.145-185.864
                                c7.046-7.423,10.571-16.084,10.571-25.981C362.597,212.321,359.071,203.755,352.025,196.712z"/>
                            </g>
                        </svg>
                    </span>
                </li>
            @endif
            @if ($items->currentPage() < $lastNumberPage - $items_to_display)
                <li class="page-item">
                    <a class="page-link" href="{{ config('app.url').$paginated_route.'/page/'. $lastNumberPage }}">
                        <svg version="1.1" class="chevron-right-double" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                        width="284.936px" height="284.936px" viewBox="0 0 284.936 284.936" style="enable-background:new 0 0 284.936 284.936;"
                        xml:space="preserve">
                            <g>
                                <path d="M277.515,135.9L144.464,2.857C142.565,0.955,140.375,0,137.9,0c-2.472,0-4.659,0.955-6.562,2.857l-14.277,14.275
                                c-1.903,1.903-2.853,4.089-2.853,6.567c0,2.478,0.95,4.664,2.853,6.567l112.207,112.204L117.062,254.677
                                c-1.903,1.903-2.853,4.093-2.853,6.564c0,2.477,0.95,4.667,2.853,6.57l14.277,14.271c1.902,1.905,4.089,2.854,6.562,2.854
                                c2.478,0,4.665-0.951,6.563-2.854l133.051-133.044c1.902-1.902,2.851-4.093,2.851-6.567S279.417,137.807,277.515,135.9z"/>
                                <path d="M170.732,142.471c0-2.474-0.947-4.665-2.857-6.571L34.833,2.857C32.931,0.955,30.741,0,28.267,0s-4.665,0.955-6.567,2.857
                                L7.426,17.133C5.52,19.036,4.57,21.222,4.57,23.7c0,2.478,0.95,4.664,2.856,6.567L119.63,142.471L7.426,254.677
                                c-1.906,1.903-2.856,4.093-2.856,6.564c0,2.477,0.95,4.667,2.856,6.57l14.273,14.271c1.903,1.905,4.093,2.854,6.567,2.854
                                s4.664-0.951,6.567-2.854l133.042-133.044C169.785,147.136,170.732,144.945,170.732,142.471z"/>
                            </g>
                        </svg>
                    </a>
                </li>
            @endif
        </ul>
    </div>
@endif