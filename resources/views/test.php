namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected static function booted(): void
    {
        static::saving(function ($orderDetail) {
            if (!is_null($orderDetail->bruto) && !is_null($orderDetail->tara)) {
                $orderDetail->netto = $orderDetail->bruto - $orderDetail->tara;
            } else {
                $orderDetail->netto = null; // Optional: biar tidak error jika belum lengkap
            }
        });
    }
}