
<div class="row ">
    <div class="col-md-12">
        <form action="#" class="card card-sm" method="POST">
            @csrf
            @method('post')
            <div class="card-body row no-gutters align-items-center me-1">
               <div class="col">
                    <input type="search" name="q" value="{{ request()->q ?? '' }}" placeholder="Rechercher un produit" class="form-control form-control-borderless" name="item-name">
               </div>
               <div class="col-auto ">
                    <button type="submit" class="btn btn-success ">Recherche</button>
               </div>
            </div>

        </form>
    </div>
</div>