<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Guards the two classes of "silently broken visual" this app had:
 *
 *  - icon classes that do not exist in the bundled Material Design Icons build,
 *    which render as an empty box rather than failing loudly;
 *  - asset() paths pointing at files that are not in public/.
 *
 * Both are invisible to the route smoke test, because the page still returns
 * 200 with a hole in it.
 */
class AssetIntegrityTest extends TestCase
{
    private const ICON_CSS = 'matrix/dist/css/icons/material-design-iconic-font/css/materialdesignicons.min.css';

    /** @test */
    public function every_icon_used_exists_in_the_bundled_font(): void
    {
        $css = file_get_contents(public_path(self::ICON_CSS));
        $this->assertNotEmpty($css, 'icon stylesheet missing');

        $missing = [];
        foreach ($this->iconsUsed() as $icon => $files) {
            if (! str_contains($css, ".$icon:")) {
                $missing[] = sprintf('%s  (used in %s)', $icon, implode(', ', $files));
            }
        }

        $this->assertSame([], $missing, "Icons with no glyph in the bundled font:\n".implode("\n", $missing));
    }

    /** @test */
    public function every_static_asset_referenced_exists(): void
    {
        $missing = [];

        foreach ($this->sourceFiles() as $file) {
            $source = file_get_contents($file);

            preg_match_all("/asset\(\s*'([^'\"\\$\{]+)'\s*\)/", $source, $matches);

            foreach ($matches[1] as $path) {
                $path = trim($path);
                // Directory prefixes concatenated with a filename at runtime.
                if ($path === '' || str_ends_with($path, '/')) {
                    continue;
                }
                if (! file_exists(public_path($path))) {
                    $missing[] = sprintf('%s  (in %s)', $path, $this->relative($file));
                }
            }
        }

        $this->assertSame([], $missing, "asset() paths with no file:\n".implode("\n", $missing));
    }

    /**
     * @return array<string, array<int, string>> icon class => files using it
     */
    private function iconsUsed(): array
    {
        $found = [];

        foreach (array_merge($this->sourceFiles(), [config_path('navigation.php'), public_path('css/bisa.css')]) as $file) {
            preg_match_all('/\bmdi-[a-z0-9-]+/', file_get_contents($file), $matches);

            foreach (array_unique($matches[0]) as $icon) {
                $found[$icon][] = $this->relative($file);
            }
        }

        // `mdi` itself is the base class, not a glyph.
        unset($found['mdi-']);

        return $found;
    }

    /**
     * @return array<int, string>
     */
    private function sourceFiles(): array
    {
        $files = [];
        $it = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator(resource_path('views')));

        foreach ($it as $file) {
            if ($file->isFile() && str_ends_with($file->getFilename(), '.blade.php')) {
                $files[] = $file->getPathname();
            }
        }

        return $files;
    }

    private function relative(string $path): string
    {
        return str_replace([base_path().DIRECTORY_SEPARATOR, '\\'], ['', '/'], $path);
    }
}
