<?php

use Illuminate\Database\Seeder;
use Katniss\Everdeen\Models\Conversation;
use Katniss\Everdeen\Models\Channel;

class ConversationSeeder extends Seeder
{
    public function run()
    {
        $this->createConversation(2, 3);
        $this->createConversation(1, 2);
    }

    protected function createConversation($user1Id, $user2Id)
    {
        $channel = Channel::create([
            'type' => Channel::TYPE_CONVERSATION,
        ]);
        $conversation = Conversation::create([
            'channel_id' => $channel->id,
            'type' => Conversation::TYPE_DIRECT,
        ]);
        $conversation->users()->attach([$user1Id, $user2Id]);
        $channel->subscribers()->attach([$user1Id, $user2Id]);
    }
}
