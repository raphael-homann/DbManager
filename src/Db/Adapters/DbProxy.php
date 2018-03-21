<?php
/**
 * Created by PhpStorm.
 * User: raph
 * Date: 14/12/16
 * Time: 04:31
 */

namespace Efrogg\Db\Adapters;


use Efrogg\Db\Context\DbQueryContextInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DbProxy extends AbstractDbAdapter
{

    /** @var  DbAdapter */
    protected $dbAdapter;

    public function setAdapter(DbAdapter $adapter)
    {
        $this->dbAdapter = $adapter;
//        $this->throwsExceptions();
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->dbAdapter->getError();
    }

    /**
     * @return int
     */
    public function getInsertId()
    {
        return $this->dbAdapter->getInsertId();
    }

    /**
     * @return int
     */
    public function getAffectedRows()
    {
        return $this->dbAdapter->getAffectedRows();
    }

    public function throwsExceptions($throws = true)
    {
        parent::throwsExceptions($throws);
        $this->dbAdapter->throwsExceptions($throws);
    }

    public function getName()
    {
        return $this->dbAdapter->getName();
    }

    /**
     * @param $query
     * @param array $params
     * @param DbQueryContextInterface $context
     * @return DbResultAdapter
     */
    public function execute($query, $params = array(), DbQueryContextInterface $context = null)
    {
        return $this->dbAdapter->execute($query, $params, $context);
    }

    /**
     * Dispatches an event to all registered listeners.
     *
     * @param string $eventName The name of the event to dispatch. The name of
     *                          the event is the name of the method that is
     *                          invoked on listeners.
     * @param Event $event The event to pass to the event handlers/listeners
     *                          If not supplied, an empty Event instance is created.
     *
     * @return Event
     */
    public function dispatch($eventName, Event $event = null)
    {
        return $this->dbAdapter->dispatch($eventName, $event);
    }

    /**
     * Adds an event listener that listens on the specified events.
     *
     * @param string $eventName The event to listen on
     * @param callable $listener The listener
     * @param int $priority The higher this value, the earlier an event
     *                            listener will be triggered in the chain (defaults to 0)
     */
    public function addListener($eventName, $listener, $priority = 0)
    {
        $this->dbAdapter->addListener($eventName, $listener, $priority);
    }

    /**
     * Adds an event subscriber.
     *
     * The subscriber is asked for all the events he is
     * interested in and added as a listener for these events.
     *
     * @param EventSubscriberInterface $subscriber The subscriber
     */
    public function addSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dbAdapter->addSubscriber($subscriber);
    }

    /**
     * Removes an event listener from the specified events.
     *
     * @param string $eventName The event to remove a listener from
     * @param callable $listener The listener to remove
     */
    public function removeListener($eventName, $listener)
    {
        $this->dbAdapter->removeListener($eventName, $listener);
    }

    /**
     * Removes an event subscriber.
     *
     * @param EventSubscriberInterface $subscriber The subscriber
     */
    public function removeSubscriber(EventSubscriberInterface $subscriber)
    {
        $this->dbAdapter->removeSubscriber($subscriber);
    }

    /**
     * Gets the listeners of a specific event or all listeners sorted by descending priority.
     *
     * @param string $eventName The name of the event
     *
     * @return array The event listeners for the specified event, or all event listeners by event name
     */
    public function getListeners($eventName = null)
    {
        return $this->dbAdapter->getListeners($eventName);
    }

    /**
     * Gets the listener priority for a specific event.
     *
     * Returns null if the event or the listener does not exist.
     *
     * @param string $eventName The name of the event
     * @param callable $listener The listener
     *
     * @return int|null The event listener priority
     */
    public function getListenerPriority($eventName, $listener)
    {
        return $this->dbAdapter->getListenerPriority($eventName, $listener);
    }

    /**
     * Checks whether an event has any registered listeners.
     *
     * @param string $eventName The name of the event
     *
     * @return bool true if the specified event has any listeners, false otherwise
     */
    public function hasListeners($eventName = null)
    {
        return $this->dbAdapter->hasListeners($eventName);
    }
}