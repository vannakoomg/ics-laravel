@extends('layouts.admin')
@section('styles')
    <style>
        article {
            --img-scale: 1.001;
            --title-color: black;
            --link-icon-translate: -20px;
            --link-icon-opacity: 0;
            position: relative;
            border-radius: 8px;
            box-shadow: none;
            background: #fff;
            transform-origin: center;
            transition: all 0.4s ease-in-out;
            overflow: hidden;
        }

        article a::after {
            position: absolute;
            inset-block: 0;
            inset-inline: 0;
            cursor: pointer;
            content: "";
        }

        /* basic article elements styling */
        article h2 {
            height: 60px;
            /* margin: 0 0 18px 0; */
            /* font-family: "Bebas Neue", cursive; */
            font-size: 1.9rem;
            text-overflow: ellipsis;
            /* letter-spacing: 0.06em; */
            color: var(--title-color);
            transition: color 0.3s ease-out;
        }

        figure {
            margin: 0;
            padding: 0;
            aspect-ratio: 16 / 9;
            overflow: hidden;
        }

        article img {
            max-width: 100%;
            transform-origin: center;
            transform: scale(var(--img-scale));
            transition: transform 0.4s ease-in-out;
        }

        .article-body {
            padding: 10px;
            max-height: 55px;
            min-height: 55px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            /* -webkit-line-clamp: 2; */
        }

        article a {
            display: inline-flex;
            align-items: center;
            text-decoration: none;
            color: #28666e;
        }

        article a:focus {
            outline: 1px dotted #28666e;
        }

        article a .icon {
            min-width: 24px;
            width: 24px;
            height: 24px;
            margin-left: 5px;
            transform: translateX(var(--link-icon-translate));
            opacity: var(--link-icon-opacity);
            transition: all 0.3s;
        }

        /* using the has() relational pseudo selector to update our custom properties */
        article:has(:hover, :focus) {
            --img-scale: 1.1;
            --title-color: #28666e;
            --link-icon-translate: 0;
            --link-icon-opacity: 1;
            box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px, rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
        }

        *,
        *::before,
        *::after {
            box-sizing: border-box;
        }

        .articles {
            display: grid;
            max-width: 20%;
            margin-inline: auto;
            padding-inline: 24px;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 24px;
        }

        @media screen and (max-width: 960px) {
            article {
                container: card/inline-size;
            }

            .article-body p {
                display: none;
            }
        }

        @container card (min-width: 380px) {
            .article-wrapper {
                display: grid;
                grid-template-columns: 20px 1fr;
                gap: 15px;


            }



            figure {
                width: 100%;
                height: 100%;
                overflow: hidden;
            }

            figure img {
                height: 120%;
                aspect-ratio: 1;
                object-fit: contain;
            }
        }

        .sr-only:not(:focus):not(:active) {
            clip: rect(0 0 0 0);
            clip-path: inset(50%);
            height: 1px;
            overflow: hidden;
            position: absolute;
            white-space: nowrap;
            width: 1px;
        }
    </style>
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            Gallery
        </div>
        <div class="card-body bg-instagram">
            {{-- @can('school_class_create') --}}
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route('admin.gallary.create') }}">
                        Add
                    </a>
                </div>
            </div>
            {{-- @endcan --}}
            {{-- @can('school_class_create') --}}
            <div>
                <div class="d-flex flex-column bd-highlight mb-3">
                    @foreach ($data as $value)
                        <h4 style="color: #ffffff; margin-top: 10px;">{{ $value['year_month'] }}</h4>
                        <div class="d-flex flex-wrap">
                            @foreach ($value['gallary'] as $value02)
                                <div class="w-25 pb-2 article-wrapper">
                                    <article class="mr-3 mb-1">
                                        <div class="">
                                            <figure>
                                                <img src={{ $value02['image'] }} alt="" />
                                            </figure>
                                            <h6 class="article-body">
                                                {{ $value02['title'] }}
                                            </h6>
                                            <div class="mb-2 ml-2">
                                                <form class="w-75" method="POST"
                                                    action="{{ route('admin.gallary.destroyGallary') }}"
                                                    onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                    enctype="multipart/form-data">
                                                    @csrf

                                                    <form>


                                            </div>


                                        </div>
                                    </article>
                                    <button class="btn btn-xs btn-danger " name="id"
                                        value={{ $value02['id'] }}>Delete</button>
                                    <a class="btn btn-xs btn-facebook"
                                        href="{{ route('admin.gallary.edit', $value02['id']) }}">Edit</a>


                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- @endcan --}}
        </div>
    </div>
@endsection
