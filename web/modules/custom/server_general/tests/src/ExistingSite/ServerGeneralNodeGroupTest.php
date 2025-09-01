<?php

namespace Drupal\Tests\server_general\ExistingSite;

use Symfony\Component\HttpFoundation\Response;
use Drupal\og\OgMembershipInterface;
use Drupal\Tests\server_general\Traits\OgMembershipCreationTrait;

/**
 * Test 'group' content type & OG subscribe message.
 */
class ServerGeneralNodeGroupTest extends ServerGeneralTestBase {

  use OgMembershipCreationTrait;

  /**
   * {@inheritdoc}
   */
  public function testSubscribeMessage() {
    $user = $this->createUser([], "Abdullah");

    $node_title = 'Drupal WOWs';
    // Create Group node.
    $node = $this->createNode([
      'title' => $node_title,
      'type' => 'group',
      'uid' => 1,
      'body' => 'Brief, Concise and short but practical demos of some of the powerful no-code features of Drupal.',
      'moderation_state' => 'published',
    ]);
    $node->save();

    $groupPendingMember = $this->createNode([
      'title' => $node_title,
      'type' => 'group',
      'uid' => 1,
      'body' => 'Brief, Concise and short but practical demos of some of the powerful no-code features of Drupal.',
      'moderation_state' => 'published',
    ]);
    $node->save();

    $groupActiveMember = $this->createNode([
      'title' => $node_title,
      'type' => 'group',
      'uid' => 1,
      'body' => 'Brief, Concise and short but practical demos of some of the powerful no-code features of Drupal.',
      'moderation_state' => 'published',
    ]);
    $node->save();

    $groupBlockedMember = $this->createNode([
      'title' => $node_title,
      'type' => 'group',
      'uid' => 1,
      'body' => 'Brief, Concise and short but practical demos of some of the powerful no-code features of Drupal.',
      'moderation_state' => 'published',
    ]);
    $node->save();

    $this->createOgMembership($groupPendingMember, $user, NULL, OgMembershipInterface::STATE_PENDING);
    $this->createOgMembership($groupActiveMember, $user, NULL, OgMembershipInterface::STATE_ACTIVE);
    $this->createOgMembership($groupBlockedMember, $user, NULL, OgMembershipInterface::STATE_BLOCKED);

    // Visit as anonymous.
    $this->drupalGet($node->toUrl());
    $this->assertSession()->elementNotExists('css', 'em.subscribe-msg');

    // Visit as authenticated non-member.
    $this->drupalLogin($user);
    $this->drupalGet($node->toUrl());
    $this->assertSession()->statusCodeEquals(Response::HTTP_OK);
    $this->assertSession()->pageTextContains($node_title);
    $this->assertSession()->elementExists('css', 'em.subscribe-msg');
    $this->assertSession()->elementTextContains('css', 'em.subscribe-msg', "Abdullah");

    // Assert subscribe message for pending group member.
    $this->drupalGet($groupPendingMember->toUrl());
    $this->assertSession()->elementNotExists('css', 'em.subscribe-msg');

    // Assert subscribe message for active group member.
    $this->drupalGet($groupActiveMember->toUrl());
    $this->assertSession()->elementNotExists('css', 'em.subscribe-msg');

    // Assert subscribe message for blocked group member.
    $this->drupalGet($groupBlockedMember->toUrl());
    $this->assertSession()->elementNotExists('css', 'em.subscribe-msg');
  }

}
