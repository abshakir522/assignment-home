<?php

declare(strict_types=1);

namespace Drupal\server_general\ThemeTrait;

use Drupal\server_general\ThemeTrait\Enum\BackgroundColorEnum;
use Drupal\Core\StringTranslation\TranslatableMarkup;

/**
 * Helper methods for rendering text badges.
 */
trait TextBadgeThemeTrait {

  /**
   * Build a text badge.
   *
   * @param string $content
   *   The content of the badge.
   * @param \Drupal\server_general\ThemeTrait\Enum\BackgroundColorEnum $bgColor
   *   The background color.
   *
   * @return array
   *   Render array.
   */
  protected function buildElementBadge(string|TranslatableMarkup $content, BackgroundColorEnum $bgColor = BackgroundColorEnum::Green): array {
    return [
      '#theme' => 'server_theme_element__badge',
      '#content' => $content,
      '#bg_color' => $bgColor->value,
    ];
  }

}
