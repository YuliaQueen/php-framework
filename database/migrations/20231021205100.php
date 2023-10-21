<?php
//TODO
return new class {
    public function up(): void
    {
        echo get_class($this) . ' up' . PHP_EOL;
    }

    public function down(): void
    {
        echo get_class($this) . ' down' . PHP_EOL;
    }
};