@extends('layouts.empty')

@section('content')
    <div class="left-panel">
        <div class="stores-title">{{ __('Online stores') }}</div>
        <ul>
            @foreach($stores as $store)
                <li class="stores-item">
                    <a href="{{ route('store.show', ['store' => $store->name]) }}" class="stores-item-link">
                        <img src="{{ $store->logo }}" alt="{{ $store->name }}" class="store-logo" />
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    <div class="right-panel">
        <div class="breadcrumbs">
            <ul>
                <li>
                    <a href="{{ route('page.home') }}" class="breadcrumbs-home-link">
                        <svg version="1.1" class="home-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 27.02 27.02" xml:space="preserve">
                            <g>
                                <path d="M3.674,24.876c0,0-0.024,0.604,0.566,0.604c0.734,0,6.811-0.008,6.811-0.008l0.01-5.581
                                c0,0-0.096-0.92,0.797-0.92h2.826c1.056,0,0.991,0.92,0.991,0.92l-0.012,5.563c0,0,5.762,0,6.667,0
                                c0.749,0,0.715-0.752,0.715-0.752V14.413l-9.396-8.358l-9.975,8.358C3.674,14.413,3.674,24.876,3.674,24.876z"></path>
                                <path d="M0,13.635c0,0,0.847,1.561,2.694,0l11.038-9.338l10.349,9.28c2.138,1.542,2.939,0,2.939,0
                                L13.732,1.54L0,13.635z"></path>
                                <polygon points="23.83,4.275 21.168,4.275 21.179,7.503 23.83,9.752"></polygon>
                            </g>
                        </svg>
                    </a>
                </li>
                <li><span>/</span></li>
                <li class="breadcrumbs-bold-item">{{ __('Stores') }}</li>
            </ul>
        </div>
        <a href="{{ route('store.show', ['store' => $store->name]) }}" class="store-name">
            <img src="{{ $store->logo }}" alt="{{ $store->name }}" class="store-logo" />
        </a>
        <div class="offers-block owl-carousel">
            @foreach($sshinas as $sshina)
                <div class="offer">
                    <a href="{{ $sshina->url }}" class="offer-link offer-image-link">
                        <img src="{{ $sshina->picture }}" alt="{{ $sshina->name }}" class="offer-image" />
                    </a>
                    <div class="offer-table">
                        <div class="offer-row">
                            <div class="offer-cell-header">
                                <div>{{ __('Category:') }}</div>
                            </div>
                            <div class="offer-cell">
                                <div class="offer-cell-data">
                                    <div class="offer-category">{{ $sshina->category->name }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="offer-row">
                            <div class="offer-cell-header">
                                <div>{{ __('Name:') }}</div>
                            </div>
                            <div class="offer-cell">
                                <div class="offer-cell-data">
                                    <a href="{{ $sshina->url }}" class="offer-link">{{ $sshina->name }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="offer-row">
                            <div class="offer-cell-header">
                                <div>{{ __('Vendor:') }}</div>
                            </div>
                            <div class="offer-cell">
                                <div class="offer-cell-data">
                                    <div class="vendor-name">{{ $sshina->vendor }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="offer-row">
                            <div class="offer-cell-header">
                                <div>{{ __('Price:') }}</div>
                            </div>
                            <div class="offer-cell">
                                <div class="offer-cell-data">
                                    <div class="offer-price">{{ $sshina->price }}</div>
                                    <svg version="1.1" class="ruble-svg" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 510.127 510.127" style="enable-background:new 0 0 510.127 510.127;"
                                    xml:space="preserve">
                                        <g>
                                            <g>
                                                <path d="M34.786,428.963h81.158v69.572c0,3.385,1.083,6.156,3.262,8.322c2.173,2.18,4.951,3.27,8.335,3.27h60.502
                                                c3.14,0,5.857-1.09,8.152-3.27c2.295-2.166,3.439-4.938,3.439-8.322v-69.572h182.964c3.377,0,6.156-1.076,8.334-3.256
                                                c2.18-2.178,3.262-4.951,3.262-8.336v-46.377c0-3.365-1.082-6.156-3.262-8.322c-2.172-2.18-4.957-3.27-8.334-3.27H199.628v-42.754
                                                h123.184c48.305,0,87.73-14.719,118.293-44.199c30.551-29.449,45.834-67.49,45.834-114.125c0-46.604-15.283-84.646-45.834-114.125
                                                C410.548,14.749,371.116,0,322.812,0H127.535c-3.385,0-6.157,1.089-8.335,3.256c-2.173,2.179-3.262,4.969-3.262,8.335v227.896
                                                H34.786c-3.384,0-6.157,1.145-8.335,3.439c-2.172,2.295-3.262,5.012-3.262,8.151v53.978c0,3.385,1.083,6.158,3.262,8.336
                                                c2.179,2.18,4.945,3.256,8.335,3.256h81.158v42.754H34.786c-3.384,0-6.157,1.09-8.335,3.27c-2.172,2.166-3.262,4.951-3.262,8.322
                                                v46.377c0,3.385,1.083,6.158,3.262,8.336C28.629,427.887,31.401,428.963,34.786,428.963z M199.628,77.179h115.938
                                                c25.6,0,46.248,7.485,61.953,22.46c15.697,14.976,23.549,34.547,23.549,58.691c0,24.156-7.852,43.733-23.549,58.691
                                                c-15.705,14.988-36.354,22.473-61.953,22.473H199.628V77.179z"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection