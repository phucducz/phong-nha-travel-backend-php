<?php
class Functions
{
    function currency_format($number, $suffix = 'đ')
    {
        if (!empty($number)) {
            return number_format($number, 0, ',', '.') . "{$suffix}";
        }
    }

    public function split_payload($payload, $split)
    {
        $listPayload = explode($split, $payload);
        $newPayload = '';

        if (count($listPayload) === 1)
            return $listPayload[0];
        else {
            foreach ($listPayload as $payload)
                $newPayload .= $payload . ' ';
        }

        return $newPayload;
    }

    public function string_concatenation($length, $object)
    {
        $string = "";
        $i = 0;

        if ($length == 0)
            return $string;

        foreach ($object as $item) {
            if ($length == 1)
                $string = "'" . $item->id . "'";
            else {
                if ($i == 0)
                    $string .= "'" . $item->id . ",";
                else if ($i == $length - 1)
                    $string .= $item->id . "'";
                else
                    $string .= $item->id . ",";
                $i++;
            }
        }

        return $string;
    }
}
?>