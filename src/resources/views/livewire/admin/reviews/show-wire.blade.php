<div>
     <div class="card">
         <div class="card-header">
             <div class="space-y-indent-half">
                 @include("ur::admin.reviews.includes.show-title")
                 <x-tt::notifications.error />
                 <x-tt::notifications.success />
             </div>
         </div>
         <div class="card-body">
             <div class="row">
                 <div class="col w-full md:w-1/2 mb-indent-half md:mb-0 flex flex-col gap-indent-half">
                     <div class="row">
                         <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                             <h3 class="font-semibold">Имя</h3>
                         </div>
                         <div class="col w-full xs:w-3/5 mb-indent-half xs:mb-0">
                             {{ $review->name }}
                         </div>
                     </div>

                     <div class="row">
                         <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                             <h3 class="font-semibold">Дата</h3>
                         </div>
                         <div class="col w-full xs:w-3/5 mb-indent-half xs:mb-0">
                             {{ $review->registered_human }}
                         </div>
                     </div>

                     <div class="row">
                         <div class="col w-full xs:w-2/5 mb-indent-half xs:mb-0">
                             <h3 class="font-semibold">Ответы</h3>
                         </div>
                         <div class="col w-full xs:w-3/5 mb-indent-half xs:mb-0">
                             @include("ur::admin.reviews.includes.answers", ["review" => $review])
                         </div>
                     </div>
                 </div>
                 <div class="col w-full md:w-1/2 mb-indent-half md:mb-0">
                     <div class="mb-2">
                         <h3 class="font-semibold">Комментарий</h3>
                     </div>
                     <div class="mb-indent-half">
                         {!! $review->markdown !!}
                     </div>
                 </div>
             </div>
         </div>
     </div>

    @include("ur::admin.reviews.includes.table-modals")
</div>
