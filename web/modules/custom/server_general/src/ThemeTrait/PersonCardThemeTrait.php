<?php

declare(strict_types=1);

namespace Drupal\server_general\ThemeTrait;

use Drupal\server_general\ThemeTrait\Enum\AlignmentEnum;
use Drupal\server_general\ThemeTrait\Enum\FontSizeEnum;
use Drupal\server_general\ThemeTrait\Enum\FontWeightEnum;
use Drupal\server_general\ThemeTrait\Enum\TextColorEnum;
use Drupal\server_general\ThemeTrait\Enum\BackgroundColorEnum;

/**
 * Helper methods for rendering Person cards.
 */
trait PersonCardThemeTrait {

  use ElementWrapThemeTrait;
  use TextBadgeThemeTrait;

  /**
   * Build Person cards.
   *
   * @param string $title
   *   The title.
   * @param array $body
   *   The body render array.
   * @param array $items
   *   The render array built with
   *   `ElementLayoutThemeTrait::buildElementLayoutTitleBodyAndItems`.
   *
   * @return array
   *   The render array.
   */
  protected function buildElementPersonCards(string $title, array $body, array $items): array {
    return $this->buildElementLayoutTitleBodyAndItems(
      $title,
      $body,
      $this->buildCards($items),
    );
  }

  /**
   * Build a Person card.
   *
   * @param string $image_url
   *   The URL of the image.
   * @param string $title
   *   The title.
   * @param string $subtitle
   *   The subtitle.
   * @param string $role
   *   The role or designation to display as badge.
   * @param string|null $email
   *   The email address.
   *   If NULL, href will be empty. Defaults to NULL.
   * @param string|null $phone
   *   The phone number.
   *   If NULL, href will be empty. Defaults to NULL.
   *
   * @return array
   *   Render array.
   */
  protected function buildElementPersonCard(string $image_url, string $title, string $subtitle, string $role, ?string $email = NULL, ?string $phone = NULL): array {
    $elements = [];
    $element = [
      '#theme' => 'image',
      '#uri' => $image_url,
      '#alt' => $title,
      '#width' => 128,
    ];

    $elements[] = $this->wrapRoundedCornersFull($element);

    $inner_elements = [];

    $element = $this->wrapTextFontWeight($title, FontWeightEnum::Medium);
    $inner_elements[] = $this->wrapTextCenter($element);

    if ($subtitle) {
      $element = $this->wrapTextResponsiveFontSize($subtitle, FontSizeEnum::Sm);
      $element = $this->wrapTextCenter($element);
      $inner_elements[] = $this->wrapTextColor($element, TextColorEnum::Gray);
    }

    $inner_elements[] = $this->wrapTextCenter($this->buildElementBadge($role, BackgroundColorEnum::Green));

    $elements[] = $this->wrapContainerVerticalSpacingTiny($inner_elements, AlignmentEnum::Center);

    return [
      '#theme' => 'server_theme_element__person_card',
      '#elements' => $this->wrapContainerVerticalSpacingBig($elements, AlignmentEnum::Center),
      '#email' => $email,
      '#phone' => $phone,
    ];
  }

}
